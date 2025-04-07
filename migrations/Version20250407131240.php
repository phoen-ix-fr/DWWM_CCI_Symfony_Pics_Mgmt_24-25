<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250407131240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE picture_user (picture_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_327353DCEE45BDBF (picture_id), INDEX IDX_327353DCA76ED395 (user_id), PRIMARY KEY(picture_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture_user ADD CONSTRAINT FK_327353DCEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_user ADD CONSTRAINT FK_327353DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture_user DROP FOREIGN KEY FK_327353DCEE45BDBF');
        $this->addSql('ALTER TABLE picture_user DROP FOREIGN KEY FK_327353DCA76ED395');
        $this->addSql('DROP TABLE picture_user');
    }
}
