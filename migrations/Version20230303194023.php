<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303194023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, image VARCHAR(800) NOT NULL, INDEX IDX_C0155143A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, modification_date DATETIME DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, prix_total DOUBLE PRECISION NOT NULL, is_paid TINYINT(1) NOT NULL, is_canceled TINYINT(1) NOT NULL, INDEX IDX_6EEAA67D67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, lieu VARCHAR(255) NOT NULL, date_debut_e DATE NOT NULL, date_fin_e DATE NOT NULL, affiche_e VARCHAR(255) DEFAULT NULL, prix_ticket DOUBLE PRECISION NOT NULL, nbr_places INT NOT NULL, description_event VARCHAR(2000) DEFAULT NULL, nom_event VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, produits_id INT DEFAULT NULL, commandes_id INT DEFAULT NULL, quantite INT NOT NULL, INDEX IDX_24CC0DF2CD11A2CF (produits_id), INDEX IDX_24CC0DF28BF5C2E6 (commandes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation_evenement (id INT AUTO_INCREMENT NOT NULL, users_event_fk_id INT NOT NULL, p_event_fk_id INT NOT NULL, nbr_participants_e INT NOT NULL, INDEX IDX_65A1467513D9940E (users_event_fk_id), INDEX IDX_65A146757484E66B (p_event_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participations (id INT AUTO_INCREMENT NOT NULL, idseancefk_id INT NOT NULL, nom_joueur VARCHAR(255) NOT NULL, nombre_participants INT NOT NULL, niveau VARCHAR(255) NOT NULL, date_participations DATE NOT NULL, INDEX IDX_FDC6C6E8F2033BB7 (idseancefk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, nom_produit VARCHAR(255) NOT NULL, prix INT NOT NULL, quantite_stock INT NOT NULL, image VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, creation_date DATETIME DEFAULT NULL, modification_date DATETIME DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, INDEX IDX_29A5EC27BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE roles (id INT AUTO_INCREMENT NOT NULL, type_role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seancecoaching (id INT AUTO_INCREMENT NOT NULL, date_debut_seance DATE NOT NULL, date_fin_seance DATE NOT NULL, prix_seance DOUBLE PRECISION NOT NULL, description_seance VARCHAR(255) NOT NULL, image_seance VARCHAR(255) NOT NULL, titre_seance VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sponsor (id INT AUTO_INCREMENT NOT NULL, idevents_fk_id INT NOT NULL, nom_sponsor VARCHAR(255) NOT NULL, num_tel_sponsor VARCHAR(255) DEFAULT NULL, email_sponsor VARCHAR(255) NOT NULL, domaine_sponsor VARCHAR(255) DEFAULT NULL, adresse_sponsor VARCHAR(255) DEFAULT NULL, logo_sponsor VARCHAR(255) NOT NULL, montant_sponsoring DOUBLE PRECISION NOT NULL, INDEX IDX_818CC9D45364AEFF (idevents_fk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournois (id INT AUTO_INCREMENT NOT NULL, idjeuxfk_id INT DEFAULT NULL, nbrparticipants INT NOT NULL, duree_tournois VARCHAR(255) NOT NULL, date_debut_tournois DATE NOT NULL, INDEX IDX_D7AAF97F3208653 (idjeuxfk_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, roles_id INT NOT NULL, tournois_id INT DEFAULT NULL, participations_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, INDEX IDX_8D93D64938C751C4 (roles_id), INDEX IDX_8D93D649752534C (tournois_id), INDEX IDX_8D93D6492E175398 (participations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2CD11A2CF FOREIGN KEY (produits_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF28BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE participation_evenement ADD CONSTRAINT FK_65A1467513D9940E FOREIGN KEY (users_event_fk_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation_evenement ADD CONSTRAINT FK_65A146757484E66B FOREIGN KEY (p_event_fk_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE participations ADD CONSTRAINT FK_FDC6C6E8F2033BB7 FOREIGN KEY (idseancefk_id) REFERENCES seancecoaching (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE sponsor ADD CONSTRAINT FK_818CC9D45364AEFF FOREIGN KEY (idevents_fk_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE tournois ADD CONSTRAINT FK_D7AAF97F3208653 FOREIGN KEY (idjeuxfk_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64938C751C4 FOREIGN KEY (roles_id) REFERENCES roles (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492E175398 FOREIGN KEY (participations_id) REFERENCES participations (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143A76ED395');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D67B3B43D');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2CD11A2CF');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF28BF5C2E6');
        $this->addSql('ALTER TABLE participation_evenement DROP FOREIGN KEY FK_65A1467513D9940E');
        $this->addSql('ALTER TABLE participation_evenement DROP FOREIGN KEY FK_65A146757484E66B');
        $this->addSql('ALTER TABLE participations DROP FOREIGN KEY FK_FDC6C6E8F2033BB7');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27BCF5E72D');
        $this->addSql('ALTER TABLE sponsor DROP FOREIGN KEY FK_818CC9D45364AEFF');
        $this->addSql('ALTER TABLE tournois DROP FOREIGN KEY FK_D7AAF97F3208653');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64938C751C4');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649752534C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6492E175398');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE participation_evenement');
        $this->addSql('DROP TABLE participations');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE roles');
        $this->addSql('DROP TABLE seancecoaching');
        $this->addSql('DROP TABLE sponsor');
        $this->addSql('DROP TABLE tournois');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
