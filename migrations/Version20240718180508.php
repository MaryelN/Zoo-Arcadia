<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240718180508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F3DA5256D');
        $this->addSql('DROP INDEX IDX_6AAB231F3DA5256D ON animal');
        $this->addSql('ALTER TABLE animal DROP image_id');
        $this->addSql('ALTER TABLE habitat ADD image_name VARCHAR(100) NOT NULL, ADD image_size INT NOT NULL, ADD updated_at DATETIME NOT NULL, ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F5EB747A3');
        $this->addSql('DROP INDEX IDX_C53D045F5EB747A3 ON image');
        $this->addSql('ALTER TABLE image CHANGE animal_id_id animal_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F8E962C16 ON image (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE habitat DROP image_name, DROP image_size, DROP updated_at, DROP created_at');
        $this->addSql('ALTER TABLE animal ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F3DA5256D ON animal (image_id)');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F8E962C16');
        $this->addSql('DROP INDEX IDX_C53D045F8E962C16 ON image');
        $this->addSql('ALTER TABLE image CHANGE animal_id animal_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F5EB747A3 ON image (animal_id_id)');
    }
}
