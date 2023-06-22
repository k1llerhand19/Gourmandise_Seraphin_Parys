<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230621110831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualites DROP FOREIGN KEY FK_75315B6D3DA5256D');
        $this->addSql('DROP INDEX UNIQ_75315B6D3DA5256D ON actualites');
        $this->addSql('ALTER TABLE actualites ADD nom_image VARCHAR(50) NOT NULL, ADD titre VARCHAR(100) NOT NULL, ADD description VARCHAR(255) NOT NULL, DROP image_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualites ADD image_id INT NOT NULL, DROP nom_image, DROP titre, DROP description');
        $this->addSql('ALTER TABLE actualites ADD CONSTRAINT FK_75315B6D3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_75315B6D3DA5256D ON actualites (image_id)');
    }
}
