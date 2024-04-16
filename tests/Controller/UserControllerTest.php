<?php

namespace App\Test\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/users/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(User::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'user[name]' => 'Testing',
            'user[email]' => 'Testing',
            'user[phonenum]' => 'Testing',
            'user[gender]' => 'Testing',
            'user[adresse]' => 'Testing',
            'user[age]' => 'Testing',
            'user[password]' => 'Testing',
            'user[joindate]' => 'Testing',
            'user[role]' => 'Testing',
            'user[height]' => 'Testing',
            'user[weight]' => 'Testing',
            'user[recetteId]' => 'Testing',
            'user[conseilId]' => 'Testing',
            'user[feedbackId]' => 'Testing',
            'user[recoveryCode]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setName('My Title');
        $fixture->setEmail('My Title');
        $fixture->setPhonenum('My Title');
        $fixture->setGender('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setAge('My Title');
        $fixture->setPassword('My Title');
        $fixture->setJoindate('My Title');
        $fixture->setRole('My Title');
        $fixture->setHeight('My Title');
        $fixture->setWeight('My Title');
        $fixture->setRecetteId('My Title');
        $fixture->setConseilId('My Title');
        $fixture->setFeedbackId('My Title');
        $fixture->setRecoveryCode('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setName('Value');
        $fixture->setEmail('Value');
        $fixture->setPhonenum('Value');
        $fixture->setGender('Value');
        $fixture->setAdresse('Value');
        $fixture->setAge('Value');
        $fixture->setPassword('Value');
        $fixture->setJoindate('Value');
        $fixture->setRole('Value');
        $fixture->setHeight('Value');
        $fixture->setWeight('Value');
        $fixture->setRecetteId('Value');
        $fixture->setConseilId('Value');
        $fixture->setFeedbackId('Value');
        $fixture->setRecoveryCode('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'user[name]' => 'Something New',
            'user[email]' => 'Something New',
            'user[phonenum]' => 'Something New',
            'user[gender]' => 'Something New',
            'user[adresse]' => 'Something New',
            'user[age]' => 'Something New',
            'user[password]' => 'Something New',
            'user[joindate]' => 'Something New',
            'user[role]' => 'Something New',
            'user[height]' => 'Something New',
            'user[weight]' => 'Something New',
            'user[recetteId]' => 'Something New',
            'user[conseilId]' => 'Something New',
            'user[feedbackId]' => 'Something New',
            'user[recoveryCode]' => 'Something New',
        ]);

        self::assertResponseRedirects('/users/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getPhonenum());
        self::assertSame('Something New', $fixture[0]->getGender());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getAge());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getJoindate());
        self::assertSame('Something New', $fixture[0]->getRole());
        self::assertSame('Something New', $fixture[0]->getHeight());
        self::assertSame('Something New', $fixture[0]->getWeight());
        self::assertSame('Something New', $fixture[0]->getRecetteId());
        self::assertSame('Something New', $fixture[0]->getConseilId());
        self::assertSame('Something New', $fixture[0]->getFeedbackId());
        self::assertSame('Something New', $fixture[0]->getRecoveryCode());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new User();
        $fixture->setName('Value');
        $fixture->setEmail('Value');
        $fixture->setPhonenum('Value');
        $fixture->setGender('Value');
        $fixture->setAdresse('Value');
        $fixture->setAge('Value');
        $fixture->setPassword('Value');
        $fixture->setJoindate('Value');
        $fixture->setRole('Value');
        $fixture->setHeight('Value');
        $fixture->setWeight('Value');
        $fixture->setRecetteId('Value');
        $fixture->setConseilId('Value');
        $fixture->setFeedbackId('Value');
        $fixture->setRecoveryCode('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/users/');
        self::assertSame(0, $this->repository->count([]));
    }
}
