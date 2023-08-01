<?php

namespace App\Test\Controller;

use App\Booking\Domain\Entity\Booking;
use App\Booking\Infrastructure\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private BookingRepository $repository;
    private string $path = '/booking/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Booking::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Booking index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'booking[dateStart]' => 'Testing',
            'booking[dateEnd]' => 'Testing',
            'booking[notes]' => 'Testing',
            'booking[createdAt]' => 'Testing',
            'booking[updatedAt]' => 'Testing',
            'booking[deletedAt]' => 'Testing',
            'booking[product]' => 'Testing',
            'booking[customer]' => 'Testing',
            'booking[paymentTransaction]' => 'Testing',
        ]);

        self::assertResponseRedirects('/booking/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Booking();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setNotes('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setProduct('My Title');
        $fixture->setCustomer('My Title');
        $fixture->setPaymentTransaction('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Booking');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Booking();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setNotes('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setProduct('My Title');
        $fixture->setCustomer('My Title');
        $fixture->setPaymentTransaction('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'booking[dateStart]' => 'Something New',
            'booking[dateEnd]' => 'Something New',
            'booking[notes]' => 'Something New',
            'booking[createdAt]' => 'Something New',
            'booking[updatedAt]' => 'Something New',
            'booking[deletedAt]' => 'Something New',
            'booking[product]' => 'Something New',
            'booking[customer]' => 'Something New',
            'booking[paymentTransaction]' => 'Something New',
        ]);

        self::assertResponseRedirects('/booking/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateStart());
        self::assertSame('Something New', $fixture[0]->getDateEnd());
        self::assertSame('Something New', $fixture[0]->getNotes());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getBookedProduct());
        self::assertSame('Something New', $fixture[0]->getCustomer());
        self::assertSame('Something New', $fixture[0]->getPaymentTransaction());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Booking();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setNotes('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');
        $fixture->setProduct('My Title');
        $fixture->setCustomer('My Title');
        $fixture->setPaymentTransaction('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/booking/');
    }
}
