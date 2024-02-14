<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240214132753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "column_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE db_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE depend_on_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE detail_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE index_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "table_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE view_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "column" (id INT NOT NULL, table_element_id INT DEFAULT NULL, column_name VARCHAR(255) NOT NULL, table_id INT NOT NULL, column_number INT NOT NULL, column_type INT NOT NULL, column_length INT NOT NULL, comment TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7D53877E42F17249 ON "column" (table_element_id)');
        $this->addSql('CREATE TABLE db_user (id INT NOT NULL, username VARCHAR(255) NOT NULL, unique_id INT NOT NULL, group_id INT NOT NULL, home_folder VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, default_shell VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE depend_on (id INT NOT NULL, b_table_id INT DEFAULT NULL, d_table_id INT DEFAULT NULL, b_type VARCHAR(255) NOT NULL, d_type VARCHAR(255) NOT NULL, b_table_id_original INT NOT NULL, d_table_id_original INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7615DFD912AEC5A9 ON depend_on (b_table_id)');
        $this->addSql('CREATE INDEX IDX_7615DFD91FB0B5EE ON depend_on (d_table_id)');
        $this->addSql('CREATE TABLE detail (id INT NOT NULL, table_element_id INT DEFAULT NULL, i_node INT NOT NULL, permissions VARCHAR(255) NOT NULL, count_link INT NOT NULL, file_owner VARCHAR(255) NOT NULL, file_group VARCHAR(255) NOT NULL, file_size BIGINT NOT NULL, date DATE NOT NULL, time TIME(0) WITHOUT TIME ZONE NOT NULL, file_location VARCHAR(255) NOT NULL, folder VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_extension VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2E067F9342F17249 ON detail (table_element_id)');
        $this->addSql('CREATE TABLE detail_db_user (detail_id INT NOT NULL, db_user_id INT NOT NULL, PRIMARY KEY(detail_id, db_user_id))');
        $this->addSql('CREATE INDEX IDX_D6F2C843D8D003BB ON detail_db_user (detail_id)');
        $this->addSql('CREATE INDEX IDX_D6F2C843FF1788DF ON detail_db_user (db_user_id)');
        $this->addSql('CREATE TABLE index (id INT NOT NULL, table_element_id INT DEFAULT NULL, index_name VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, table_id INT NOT NULL, index_type VARCHAR(255) NOT NULL, clustered VARCHAR(255) DEFAULT NULL, part1 INT NOT NULL, part2 INT NOT NULL, part3 INT NOT NULL, part4 INT NOT NULL, part5 INT NOT NULL, part6 INT NOT NULL, part7 INT NOT NULL, part8 INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8073670142F17249 ON index (table_element_id)');
        $this->addSql('CREATE TABLE "table" (id INT NOT NULL, table_name VARCHAR(255) NOT NULL, owner VARCHAR(255) DEFAULT NULL, db_file_name VARCHAR(255) DEFAULT NULL, tab_id INT NOT NULL, row_size INT NOT NULL, number_rows INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, version INT NOT NULL, table_type VARCHAR(255) DEFAULT NULL, aud_path VARCHAR(255) DEFAULT NULL, comment TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "table".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE view (id INT NOT NULL, table_element_id INT DEFAULT NULL, table_id INT NOT NULL, sequence_number INT NOT NULL, view_text VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEFDAB8E42F17249 ON view (table_element_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('CREATE TABLE users_session (guid VARCHAR(128) NOT NULL, sess_data BYTEA NOT NULL, sess_lifetime INT NOT NULL, sess_time INT NOT NULL, PRIMARY KEY(guid))');
        $this->addSql('CREATE INDEX sess_lifetime_idx ON users_session (sess_lifetime)');
        $this->addSql('ALTER TABLE "column" ADD CONSTRAINT FK_7D53877E42F17249 FOREIGN KEY (table_element_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depend_on ADD CONSTRAINT FK_7615DFD912AEC5A9 FOREIGN KEY (b_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depend_on ADD CONSTRAINT FK_7615DFD91FB0B5EE FOREIGN KEY (d_table_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail ADD CONSTRAINT FK_2E067F9342F17249 FOREIGN KEY (table_element_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_db_user ADD CONSTRAINT FK_D6F2C843D8D003BB FOREIGN KEY (detail_id) REFERENCES detail (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE detail_db_user ADD CONSTRAINT FK_D6F2C843FF1788DF FOREIGN KEY (db_user_id) REFERENCES db_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE index ADD CONSTRAINT FK_8073670142F17249 FOREIGN KEY (table_element_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE view ADD CONSTRAINT FK_FEFDAB8E42F17249 FOREIGN KEY (table_element_id) REFERENCES "table" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('DROP SEQUENCE "table_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE view_id_seq CASCADE');
        $this->addSql('ALTER TABLE "column" DROP CONSTRAINT FK_7D53877E42F17249');
        $this->addSql('ALTER TABLE depend_on DROP CONSTRAINT FK_7615DFD912AEC5A9');
        $this->addSql('ALTER TABLE depend_on DROP CONSTRAINT FK_7615DFD91FB0B5EE');
        $this->addSql('ALTER TABLE detail DROP CONSTRAINT FK_2E067F9342F17249');
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
        $this->addSql('DROP TABLE "table"');
        $this->addSql('DROP TABLE view');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE users_session');
    }
}
