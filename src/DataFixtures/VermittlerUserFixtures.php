<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\VermittlerUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class VermittlerUserFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager)
    {
        $this->create(
            manager: $manager,
            reference: VermittlerFixtures::KLAUS_WARNER,
            aktiv: 1,
        );
        $this->create(
            manager: $manager,
            reference: VermittlerFixtures::SVENJA_SCHUSTER,
            aktiv: 1,
        );
        $this->create(
            manager: $manager,
            reference: VermittlerFixtures::VINCENT_VINCENT,
            aktiv: 0,
        );
        $manager->flush();
    }

    private function create(
        ObjectManager $manager,
        string $reference,
        int $aktiv,
    ): void {
        $user = new VermittlerUser();
        $user->vermittler = $this->getReference($reference);
        $user->email = "$reference@email.com";
        $user->password = $this->passwordHasher->hashPassword($user, 'hackme');
        $user->aktiv = $aktiv;

        $manager->persist($user);
    }

    public function getDependencies(): array
    {
        return [
            VermittlerFixtures::class,
        ];
    }
}
