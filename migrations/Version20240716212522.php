<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716212522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD image_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F68011AFE FOREIGN KEY (image_id_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F68011AFE ON animal (image_id_id)');
        $this->addSql('ALTER TABLE image ADD image_name VARCHAR(100) NOT NULL, ADD image_size INT NOT NULL, ADD updated_at DATETIME NOT NULL, ADD created_at DATETIME NOT NULL, DROP name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F68011AFE');
        $this->addSql('DROP INDEX IDX_6AAB231F68011AFE ON animal');
        $this->addSql('ALTER TABLE animal DROP image_id_id');
        $this->addSql('ALTER TABLE image ADD name VARCHAR(50) NOT NULL, DROP image_name, DROP image_size, DROP updated_at, DROP created_at');
    }
}
