<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260506124507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD order_number VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL, ADD user_id INT NOT NULL, ADD pickup_appointment_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398CDD4F97B FOREIGN KEY (pickup_appointment_id) REFERENCES pickup_appointment (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F5299398CDD4F97B ON `order` (pickup_appointment_id)');
        $this->addSql('ALTER TABLE order_item ADD quantity INT NOT NULL, ADD order_id INT NOT NULL, ADD product_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F094584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_52EA1F098D9F6D38 ON order_item (order_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F094584665A ON order_item (product_id)');
        $this->addSql('ALTER TABLE pickup_appointment ADD date DATETIME NOT NULL, ADD location VARCHAR(255) NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE pickup_appointment ADD CONSTRAINT FK_3F0B7FC7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3F0B7FC7A76ED395 ON pickup_appointment (user_id)');
        $this->addSql('ALTER TABLE product ADD name VARCHAR(255) NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD12469DE2 ON product (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP name');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398CDD4F97B');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('DROP INDEX UNIQ_F5299398CDD4F97B ON `order`');
        $this->addSql('ALTER TABLE `order` DROP order_number, DROP created_at, DROP user_id, DROP pickup_appointment_id');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F094584665A');
        $this->addSql('DROP INDEX IDX_52EA1F098D9F6D38 ON order_item');
        $this->addSql('DROP INDEX IDX_52EA1F094584665A ON order_item');
        $this->addSql('ALTER TABLE order_item DROP quantity, DROP order_id, DROP product_id');
        $this->addSql('ALTER TABLE pickup_appointment DROP FOREIGN KEY FK_3F0B7FC7A76ED395');
        $this->addSql('DROP INDEX IDX_3F0B7FC7A76ED395 ON pickup_appointment');
        $this->addSql('ALTER TABLE pickup_appointment DROP date, DROP location, DROP user_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('DROP INDEX IDX_D34A04AD12469DE2 ON product');
        $this->addSql('ALTER TABLE product DROP name, DROP price, DROP category_id');
    }
}
