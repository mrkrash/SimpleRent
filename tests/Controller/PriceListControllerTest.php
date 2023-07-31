<?php

namespace App\Test\Controller;

use App\Product\Domain\Entity\PriceList;
use App\Product\Infrastructure\Repository\PriceListRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PriceListControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PriceListRepository $repository;
    private string $path = '/price/list/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PriceList::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PriceList index');

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
            'price_list[name]' => 'Testing',
            'price_list[price]' => 'Testing',
            'price_list[price3days]' => 'Testing',
            'price_list[price7days]' => 'Testing',
            'price_list[createdAt]' => 'Testing',
            'price_list[updatedAt]' => 'Testing',
            'price_list[deletedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/price/list/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PriceList();
        $fixture->setName('My Title');
        $fixture->setPrice('My Title');
        $fixture->setPrice3days('My Title');
        $fixture->setPrice7days('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PriceList');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PriceList();
        $fixture->setName('My Title');
        $fixture->setPrice('My Title');
        $fixture->setPrice3days('My Title');
        $fixture->setPrice7days('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'price_list[name]' => 'Something New',
            'price_list[price]' => 'Something New',
            'price_list[price3days]' => 'Something New',
            'price_list[price7days]' => 'Something New',
            'price_list[createdAt]' => 'Something New',
            'price_list[updatedAt]' => 'Something New',
            'price_list[deletedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/price/list/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getPrice());
        self::assertSame('Something New', $fixture[0]->getPrice3days());
        self::assertSame('Something New', $fixture[0]->getPrice7days());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PriceList();
        $fixture->setName('My Title');
        $fixture->setPrice('My Title');
        $fixture->setPrice3days('My Title');
        $fixture->setPrice7days('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setDeletedAt('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/price/list/');
    }
}
