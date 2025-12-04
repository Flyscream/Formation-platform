<?php

namespace App\Tests\Controller;

use App\Entity\Formation;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class FormationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $formationRepository;
    private string $path = '/yes/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->formationRepository = $this->manager->getRepository(Formation::class);

        foreach ($this->formationRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Formation index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'formation[titre]' => 'Testing',
            'formation[description]' => 'Testing',
            'formation[dureeHeures]' => 'Testing',
            'formation[niveauDifficulte]' => 'Testing',
            'formation[prix]' => 'Testing',
            'formation[dateCreation]' => 'Testing',
            'formation[estPubliee]' => 'Testing',
            'formation[capaciteMax]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->formationRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Formation();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDureeHeures('My Title');
        $fixture->setNiveauDifficulte('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDateCreation('My Title');
        $fixture->setEstPubliee('My Title');
        $fixture->setCapaciteMax('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Formation');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Formation();
        $fixture->setTitre('Value');
        $fixture->setDescription('Value');
        $fixture->setDureeHeures('Value');
        $fixture->setNiveauDifficulte('Value');
        $fixture->setPrix('Value');
        $fixture->setDateCreation('Value');
        $fixture->setEstPubliee('Value');
        $fixture->setCapaciteMax('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'formation[titre]' => 'Something New',
            'formation[description]' => 'Something New',
            'formation[dureeHeures]' => 'Something New',
            'formation[niveauDifficulte]' => 'Something New',
            'formation[prix]' => 'Something New',
            'formation[dateCreation]' => 'Something New',
            'formation[estPubliee]' => 'Something New',
            'formation[capaciteMax]' => 'Something New',
        ]);

        self::assertResponseRedirects('/yes/');

        $fixture = $this->formationRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getDureeHeures());
        self::assertSame('Something New', $fixture[0]->getNiveauDifficulte());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getDateCreation());
        self::assertSame('Something New', $fixture[0]->getEstPubliee());
        self::assertSame('Something New', $fixture[0]->getCapaciteMax());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Formation();
        $fixture->setTitre('Value');
        $fixture->setDescription('Value');
        $fixture->setDureeHeures('Value');
        $fixture->setNiveauDifficulte('Value');
        $fixture->setPrix('Value');
        $fixture->setDateCreation('Value');
        $fixture->setEstPubliee('Value');
        $fixture->setCapaciteMax('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/yes/');
        self::assertSame(0, $this->formationRepository->count([]));
    }
}
