<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514095537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos ADD commentaire_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9FAC8564B FOREIGN KEY (commentaire_id_id) REFERENCES commentaires (id)');
        $this->addSql('CREATE INDEX IDX_876E0D9FAC8564B ON photos (commentaire_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9FAC8564B');
        $this->addSql('DROP INDEX IDX_876E0D9FAC8564B ON photos');
        $this->addSql('ALTER TABLE photos DROP commentaire_id_id');
    }
}
