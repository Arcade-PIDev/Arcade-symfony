<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305213700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_user (blog_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_6D435AD9DAE07E97 (blog_id), INDEX IDX_6D435AD9A76ED395 (user_id), PRIMARY KEY(blog_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_user ADD CONSTRAINT FK_6D435AD9DAE07E97 FOREIGN KEY (blog_id) REFERENCES blog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_user ADD CONSTRAINT FK_6D435AD9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog CHANGE contenu contenu VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_user DROP FOREIGN KEY FK_6D435AD9DAE07E97');
        $this->addSql('ALTER TABLE blog_user DROP FOREIGN KEY FK_6D435AD9A76ED395');
        $this->addSql('DROP TABLE blog_user');
        $this->addSql('ALTER TABLE blog CHANGE contenu contenu LONGTEXT NOT NULL');
    }
}
