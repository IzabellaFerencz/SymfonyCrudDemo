<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191025075933 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_8D93D6491C7DC1CE ON user');
        $this->addSql('ALTER TABLE user CHANGE user_details_id user_details_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64912595E8 FOREIGN KEY (user_details_id_id) REFERENCES user_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64912595E8 ON user (user_details_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64912595E8');
        $this->addSql('DROP INDEX UNIQ_8D93D64912595E8 ON user');
        $this->addSql('ALTER TABLE user CHANGE user_details_id_id user_details_id INT DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6491C7DC1CE ON user (user_details_id)');
    }
}
