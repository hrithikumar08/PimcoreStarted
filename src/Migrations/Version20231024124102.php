<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024124102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Tracking Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `tracking_details` (
            `id` int(5) NOT NULL AUTO_INCREMENT,
            `user_id` int(5) DEFAULT 0,
            `login` datetime DEFAULT NULL,
            `logout` datetime DEFAULT NULL,
            `action` varchar(255) DEFAULT 0,
            `object_id` smallint(5) DEFAULT 0,
            PRIMARY KEY (`id`),
            KEY `user_id` (`user_id`),
            KEY `action` (`action`),
            KEY `login` (`login`),
            KEY `logout` (`logout`)
          ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP table tracking_details;');

    }
}
