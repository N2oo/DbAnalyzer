<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240215110640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE index ADD column1_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD column2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD column3_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD column4_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD column5_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD column6_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD column7_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD column8_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_80736701206B8546 FOREIGN KEY (column1_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_8073670132DE2AA8 FOREIGN KEY (column2_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_807367018A624DCD FOREIGN KEY (column3_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_8073670117B57574 FOREIGN KEY (column4_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_80736701AF091211 FOREIGN KEY (column5_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_80736701BDBCBDFF FOREIGN KEY (column6_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_80736701500DA9A FOREIGN KEY (column7_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_807367015D63CACC FOREIGN KEY (column8_id) REFERENCES "column" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_80736701206B8546 ON index (column1_id)');
        $this->addSql('CREATE INDEX IDX_8073670132DE2AA8 ON index (column2_id)');
        $this->addSql('CREATE INDEX IDX_807367018A624DCD ON index (column3_id)');
        $this->addSql('CREATE INDEX IDX_8073670117B57574 ON index (column4_id)');
        $this->addSql('CREATE INDEX IDX_80736701AF091211 ON index (column5_id)');
        $this->addSql('CREATE INDEX IDX_80736701BDBCBDFF ON index (column6_id)');
        $this->addSql('CREATE INDEX IDX_80736701500DA9A ON index (column7_id)');
        $this->addSql('CREATE INDEX IDX_807367015D63CACC ON index (column8_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_80736701206B8546');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_8073670132DE2AA8');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_807367018A624DCD');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_8073670117B57574');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_80736701AF091211');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_80736701BDBCBDFF');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_80736701500DA9A');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_807367015D63CACC');
        $this->addSql('DROP INDEX IDX_80736701206B8546');
        $this->addSql('DROP INDEX IDX_8073670132DE2AA8');
        $this->addSql('DROP INDEX IDX_807367018A624DCD');
        $this->addSql('DROP INDEX IDX_8073670117B57574');
        $this->addSql('DROP INDEX IDX_80736701AF091211');
        $this->addSql('DROP INDEX IDX_80736701BDBCBDFF');
        $this->addSql('DROP INDEX IDX_80736701500DA9A');
        $this->addSql('DROP INDEX IDX_807367015D63CACC');
        $this->addSql('ALTER TABLE index DROP column1_id');
        $this->addSql('ALTER TABLE index DROP column2_id');
        $this->addSql('ALTER TABLE index DROP column3_id');
        $this->addSql('ALTER TABLE index DROP column4_id');
        $this->addSql('ALTER TABLE index DROP column5_id');
        $this->addSql('ALTER TABLE index DROP column6_id');
        $this->addSql('ALTER TABLE index DROP column7_id');
        $this->addSql('ALTER TABLE index DROP column8_id');
    }
}
