<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260212085453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY `FK_F52993989395C3F3`');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE pickup_appointment DROP FOREIGN KEY `FK_3F0B7FC7A76ED395`');
        $this->addSql('ALTER TABLE pickup_appointment ADD CONSTRAINT FK_3F0B7FC7A76ED395 FOREIGN KEY (user_id) REFERENCES usuario (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, full_name VARCHAR(120) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, phone VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT `FK_F52993989395C3F3` FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pickup_appointment DROP FOREIGN KEY FK_3F0B7FC7A76ED395');
        $this->addSql('ALTER TABLE pickup_appointment ADD CONSTRAINT `FK_3F0B7FC7A76ED395` FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
