<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307230414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement ADD user_fk_id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E47B5E288 FOREIGN KEY (user_fk_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B26681E47B5E288 ON evenement (user_fk_id)');
        $this->addSql('ALTER TABLE participations ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FDC6C6E867B3B43D ON participations (users_id)');
        $this->addSql('ALTER TABLE tournois ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tournois ADD CONSTRAINT FK_D7AAF9767B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D7AAF9767B3B43D ON tournois (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E47B5E288');
        $this->addSql('DROP INDEX IDX_B26681E47B5E288 ON evenement');
        $this->addSql('ALTER TABLE evenement DROP user_fk_id');
        $this->addSql('ALTER TABLE participations DROP FOREIGN KEY FK_FDC6C6E867B3B43D');
        $this->addSql('DROP INDEX IDX_FDC6C6E867B3B43D ON participations');
        $this->addSql('ALTER TABLE participations DROP users_id');
        $this->addSql('ALTER TABLE tournois DROP FOREIGN KEY FK_D7AAF9767B3B43D');
        $this->addSql('DROP INDEX IDX_D7AAF9767B3B43D ON tournois');
        $this->addSql('ALTER TABLE tournois DROP users_id');
    }
}
