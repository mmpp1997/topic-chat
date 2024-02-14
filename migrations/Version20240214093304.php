<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214093304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE room_user (room_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_EE973C2D54177093 (room_id), INDEX IDX_EE973C2DA76ED395 (user_id), PRIMARY KEY(room_id, user_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE room_user ADD CONSTRAINT FK_EE973C2D54177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_user ADD CONSTRAINT FK_EE973C2DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room DROP members');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room_user DROP FOREIGN KEY FK_EE973C2D54177093');
        $this->addSql('ALTER TABLE room_user DROP FOREIGN KEY FK_EE973C2DA76ED395');
        $this->addSql('DROP TABLE room_user');
        $this->addSql('ALTER TABLE room ADD members LONGTEXT DEFAULT NULL');
    }
}
