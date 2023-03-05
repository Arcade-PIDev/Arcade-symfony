<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305004101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6CD11A2CF');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A31CD11A2CF');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6CD11A2CF');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A31CD11A2CF');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id) ON DELETE CASCADE');
    }
}
