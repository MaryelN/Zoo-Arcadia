<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710153705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, habitat_id_id INT NOT NULL, race_id_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, details VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_6AAB231F5E237E06 (name), INDEX IDX_6AAB231F20AE7A39 (habitat_id_id), INDEX IDX_6AAB231F997ABF46 (race_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_report (id INT AUTO_INCREMENT NOT NULL, animal_id_id INT NOT NULL, user_id_id INT NOT NULL, proposed_food VARCHAR(100) NOT NULL, proposed_quantity VARCHAR(50) DEFAULT NULL, details VARCHAR(100) DEFAULT NULL, INDEX IDX_7EDEB2585EB747A3 (animal_id_id), INDEX IDX_7EDEB2589D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, comment VARCHAR(150) NOT NULL, validation TINYINT(1) DEFAULT 0 NOT NULL, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE food_report (id INT AUTO_INCREMENT NOT NULL, animal_id_id INT NOT NULL, user_id_id INT DEFAULT NULL, date_time DATETIME NOT NULL, food_quantity VARCHAR(50) NOT NULL, details VARCHAR(50) DEFAULT NULL, INDEX IDX_84011D275EB747A3 (animal_id_id), INDEX IDX_84011D279D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitat (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_3B37B2E85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, animal_id_id INT NOT NULL, name VARCHAR(50) NOT NULL, INDEX IDX_C53D045F5EB747A3 (animal_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(50) NOT NULL, description VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, day_name VARCHAR(10) NOT NULL, opening TIME NOT NULL, closing TIME NOT NULL, UNIQUE INDEX UNIQ_5A3811FBF54B9370 (day_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_E19D9AD25E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, name VARCHAR(50) NOT NULL, timestamp DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F20AE7A39 FOREIGN KEY (habitat_id_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F997ABF46 FOREIGN KEY (race_id_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal_report ADD CONSTRAINT FK_7EDEB2585EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE animal_report ADD CONSTRAINT FK_7EDEB2589D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE food_report ADD CONSTRAINT FK_84011D275EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE food_report ADD CONSTRAINT FK_84011D279D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5EB747A3 FOREIGN KEY (animal_id_id) REFERENCES animal (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F20AE7A39');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F997ABF46');
        $this->addSql('ALTER TABLE animal_report DROP FOREIGN KEY FK_7EDEB2585EB747A3');
        $this->addSql('ALTER TABLE animal_report DROP FOREIGN KEY FK_7EDEB2589D86650F');
        $this->addSql('ALTER TABLE food_report DROP FOREIGN KEY FK_84011D275EB747A3');
        $this->addSql('ALTER TABLE food_report DROP FOREIGN KEY FK_84011D279D86650F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F5EB747A3');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_report');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE food_report');
        $this->addSql('DROP TABLE habitat');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
