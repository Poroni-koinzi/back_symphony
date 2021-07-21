<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312100228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE id_client');
        $this->addSql('DROP TABLE id_facture');
        $this->addSql('ALTER TABLE client CHANGE id_panier_id id_panier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande CHANGE id_facture_id id_facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_commande_id id_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE id_panier_id id_panier_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE id_client (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE id_facture (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE client CHANGE id_panier_id id_panier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande CHANGE id_facture_id id_facture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier CHANGE id_commande_id id_commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE id_panier_id id_panier_id INT DEFAULT NULL');
    }
}
