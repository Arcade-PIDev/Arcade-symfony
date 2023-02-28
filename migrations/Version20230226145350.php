<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226145350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement ADD all_day TINYINT(1) NOT NULL, ADD background_color VARCHAR(7) NOT NULL, ADD border_color VARCHAR(7) NOT NULL, ADD text_color VARCHAR(7) NOT NULL, CHANGE date_debut_e date_debut_e DATETIME NOT NULL, CHANGE date_fin_e date_fin_e DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP all_day, DROP background_color, DROP border_color, DROP text_color, CHANGE date_debut_e date_debut_e DATE NOT NULL, CHANGE date_fin_e date_fin_e DATE NOT NULL');
    }
}
