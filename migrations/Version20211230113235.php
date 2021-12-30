<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211230113235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_annonce (user_id INT NOT NULL, annonce_id INT NOT NULL, INDEX IDX_AE588DEFA76ED395 (user_id), INDEX IDX_AE588DEF8805AB2F (annonce_id), PRIMARY KEY(user_id, annonce_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEF8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE fetiche');
        $this->addSql('ALTER TABLE annonce ADD annonce_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E55D0149F5 FOREIGN KEY (annonce_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F65593E55D0149F5 ON annonce (annonce_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fetiche (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE user_annonce');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E55D0149F5');
        $this->addSql('DROP INDEX IDX_F65593E55D0149F5 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP annonce_user_id');
    }
}
