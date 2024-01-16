<?php

namespace Tests\Functional\Twig\Components;

use App\Twig\Components\NavBar;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

/**
 * @coversNothing
 */
class NavBarTest extends KernelTestCase
{
    use InteractsWithTwigComponents;

    public function testComponentMount(): void
    {
        $request = new Request();
        $request->setSession(new Session(new MockArraySessionStorage()));

        self::getContainer()->get(RequestStack::class)->push($request);

        $component = $this->mountTwigComponent(
            name: NavBar::class
        );

        self::assertInstanceOf(NavBar::class, $component);
    }

}