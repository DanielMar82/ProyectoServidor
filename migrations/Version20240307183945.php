<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240307183945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_pedido ADD producto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE linea_pedido ADD CONSTRAINT FK_183C31657645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('CREATE INDEX IDX_183C31657645698E ON linea_pedido (producto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_pedido DROP FOREIGN KEY FK_183C31657645698E');
        $this->addSql('DROP INDEX IDX_183C31657645698E ON linea_pedido');
        $this->addSql('ALTER TABLE linea_pedido DROP producto_id');
    }
}
