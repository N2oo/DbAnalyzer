<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240206111002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "table" DROP CONSTRAINT fk_f6298f462209d790');
        $this->addSql('DROP SEQUENCE database_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE field_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE "column_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE db_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE depend_on_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE index_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE view_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "column" (id INT NOT NULL, table_element_id INT DEFAULT NULL, column_name VARCHAR(255) NOT NULL, table_id INT NOT NULL, column_number INT NOT NULL, column_type INT NOT NULL, column_length INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7D53877E42F17249 ON "column" (table_element_id)');
        $this->addSql('CREATE TABLE db_user (id INT NOT NULL, username VARCHAR(255) NOT NULL, unique_id VARCHAR(255) NOT NULL, group_id VARCHAR(255) NOT NULL, home_folder VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, default_shell VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE depend_on (id INT NOT NULL, b_table_id INT NOT NULL, d_table_id INT NOT NULL, b_type VARCHAR(255) NOT NULL, d_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7615DFD912AEC5A9 ON depend_on (b_table_id)');
        $this->addSql('CREATE INDEX IDX_7615DFD91FB0B5EE ON depend_on (d_table_id)');
        $this->addSql('CREATE TABLE detail (id INT NOT NULL, i_node INT NOT NULL, permissions VARCHAR(255) NOT NULL, count_link INT NOT NULL, file_owner VARCHAR(255) NOT NULL, file_group VARCHAR(255) NOT NULL, file_size BIGINT NOT NULL, date DATE NOT NULL, time TIME(0) WITHOUT TIME ZONE NOT NULL, file_location VARCHAR(255) NOT NULL, folder VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_extension VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE detail_db_user (detail_id INT NOT NULL, db_user_id INT NOT NULL, PRIMARY KEY(detail_id, db_user_id))');
        $this->addSql('CREATE INDEX IDX_D6F2C843D8D003BB ON detail_db_user (detail_id)');
        $this->addSql('CREATE INDEX IDX_D6F2C843FF1788DF ON detail_db_user (db_user_id)');
        $this->addSql('CREATE TABLE index (id INT NOT NULL, table_element_id INT DEFAULT NULL, index_name VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, table_id INT NOT NULL, index_type VARCHAR(255) NOT NULL, clustered VARCHAR(255) DEFAULT NULL, part1 INT NOT NULL, part2 INT NOT NULL, part3 INT NOT NULL, part4 INT NOT NULL, part5 INT NOT NULL, part6 INT NOT NULL, part7 INT NOT NULL, part8 INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8073670142F17249 ON index (table_element_id)');
        $this->addSql('CREATE TABLE view (id INT NOT NULL, table_element_id INT DEFAULT NULL, table_id INT NOT NULL, sequence_number INT NOT NULL, view_text VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEFDAB8E42F17249 ON view (table_element_id)');
        $this->addSql('ALTER TABLE "column" ADD CONSTRAINT FK_7D53877E42F17249 FOREIGN KEY (table_element_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depend_on ADD CONSTRAINT FK_7615DFD912AEC5A9 FOREIGN KEY (b_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depend_on ADD CONSTRAINT FK_7615DFD91FB0B5EE FOREIGN KEY (d_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_db_user ADD CONSTRAINT FK_D6F2C843D8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_db_user ADD CONSTRAINT FK_D6F2C843FF1788DF FOREIGN KEY (db_user_id) REFERENCES db_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_8073670142F17249 FOREIGN KEY (table_element_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE view ADD CONSTRAINT FK_FEFDAB8E42F17249 FOREIGN KEY (table_element_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE field DROP CONSTRAINT fk_5bf54558a91c414e');
        $this->addSql('ALTER TABLE field DROP CONSTRAINT fk_5bf545581620ff6e');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE database');
        $this->addSql('DROP INDEX idx_f6298f462209d790');
        $this->addSql('ALTER TABLE "table" ADD owner VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "table" ADD db_file_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "table" ADD tab_id INT NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD row_size INT NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD number_rows INT NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD version INT NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD table_type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "table" ADD aud_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "table" DROP for_db_id');
        $this->addSql('ALTER TABLE "table" DROP is_view');
        $this->addSql('ALTER TABLE "table" DROP query');
        $this->addSql('ALTER TABLE "table" DROP table_original_id');
        $this->addSql('ALTER TABLE "table" DROP commentary');
        $this->addSql('ALTER TABLE "table" RENAME COLUMN name TO table_name');
        $this->addSql('COMMENT ON COLUMN "table".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE messenger_messages ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER available_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER delivered_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "column_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE db_user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE depend_on_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE detail_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE index_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE view_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE database_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE field_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE field (id INT NOT NULL, for_table_id INT NOT NULL, use_property_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type INT DEFAULT NULL, length INT NOT NULL, is_primary BOOLEAN NOT NULL, field_original_id INT NOT NULL, commentary TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_5bf545581620ff6e ON field (use_property_id)');
        $this->addSql('CREATE INDEX idx_5bf54558a91c414e ON field (for_table_id)');
        $this->addSql('CREATE TABLE database (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT fk_5bf54558a91c414e FOREIGN KEY (for_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE field ADD CONSTRAINT fk_5bf545581620ff6e FOREIGN KEY (use_property_id) REFERENCES field (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "column" DROP CONSTRAINT FK_7D53877E42F17249');
        $this->addSql('ALTER TABLE depend_on DROP CONSTRAINT FK_7615DFD912AEC5A9');
        $this->addSql('ALTER TABLE depend_on DROP CONSTRAINT FK_7615DFD91FB0B5EE');
        $this->addSql('ALTER TABLE detail_db_user DROP CONSTRAINT FK_D6F2C843D8D003BB');
        $this->addSql('ALTER TABLE detail_db_user DROP CONSTRAINT FK_D6F2C843FF1788DF');
        $this->addSql('ALTER TABLE index DROP CONSTRAINT FK_8073670142F17249');
        $this->addSql('ALTER TABLE view DROP CONSTRAINT FK_FEFDAB8E42F17249');
        $this->addSql('DROP TABLE "column"');
        $this->addSql('DROP TABLE db_user');
        $this->addSql('DROP TABLE depend_on');
        $this->addSql('DROP TABLE detail');
        $this->addSql('DROP TABLE detail_db_user');
        $this->addSql('DROP TABLE index');
        $this->addSql('DROP TABLE view');
        $this->addSql('ALTER TABLE "table" ADD for_db_id INT NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD is_view BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD query TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE "table" ADD table_original_id INT NOT NULL');
        $this->addSql('ALTER TABLE "table" ADD commentary TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE "table" DROP owner');
        $this->addSql('ALTER TABLE "table" DROP db_file_name');
        $this->addSql('ALTER TABLE "table" DROP tab_id');
        $this->addSql('ALTER TABLE "table" DROP row_size');
        $this->addSql('ALTER TABLE "table" DROP number_rows');
        $this->addSql('ALTER TABLE "table" DROP created_at');
        $this->addSql('ALTER TABLE "table" DROP version');
        $this->addSql('ALTER TABLE "table" DROP table_type');
        $this->addSql('ALTER TABLE "table" DROP aud_path');
        $this->addSql('ALTER TABLE "table" RENAME COLUMN table_name TO name');
        $this->addSql('ALTER TABLE "table" ADD CONSTRAINT fk_f6298f462209d790 FOREIGN KEY (for_db_id) REFERENCES database (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f6298f462209d790 ON "table" (for_db_id)');
        $this->addSql('ALTER TABLE messenger_messages ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER available_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER delivered_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS NULL');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS NULL');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS NULL');
    }
}
