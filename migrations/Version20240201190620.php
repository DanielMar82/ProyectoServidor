<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201190620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_pedido ADD pedidos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE linea_pedido ADD CONSTRAINT FK_183C3165213530F2 FOREIGN KEY (pedidos_id) REFERENCES pedido (id)');
        $this->addSql('CREATE INDEX IDX_183C3165213530F2 ON linea_pedido (pedidos_id)');
        $this->addSql('ALTER TABLE pedido ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CEDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_C4EC16CEDB38439E ON pedido (usuario_id)');
        $this->addSql('ALTER TABLE producto ADD lineas_pedidos_id INT DEFAULT NULL, ADD marca VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615C553D0D0 FOREIGN KEY (lineas_pedidos_id) REFERENCES linea_pedido (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615C553D0D0 ON producto (lineas_pedidos_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE linea_pedido DROP FOREIGN KEY FK_183C3165213530F2');
        $this->addSql('DROP INDEX IDX_183C3165213530F2 ON linea_pedido');
        $this->addSql('ALTER TABLE linea_pedido DROP pedidos_id');
        $this->addSql('ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CEDB38439E');
        $this->addSql('DROP INDEX IDX_C4EC16CEDB38439E ON pedido');
        $this->addSql('ALTER TABLE pedido DROP usuario_id');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615C553D0D0');
        $this->addSql('DROP INDEX IDX_A7BB0615C553D0D0 ON producto');
        $this->addSql('ALTER TABLE producto DROP lineas_pedidos_id, DROP marca');
    }
}
