<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20170422222730 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agents (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, UNIQUE INDEX UNIQ_9596AB6EA76ED395 (user_id), INDEX IDX_9596AB6EB03A8386 (created_by_id), INDEX IDX_9596AB6E99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cumulus_images (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, cumulus_record_id SMALLINT DEFAULT NULL, cumulus_catalogue VARCHAR(64) DEFAULT NULL, cumulus_record_name VARCHAR(64) DEFAULT NULL, cumulus_modified DATETIME DEFAULT NULL, thumbnail_url_enabled TINYINT(1) NOT NULL, preview_url_enabled TINYINT(1) NOT NULL, pixel_x_dimension INT DEFAULT NULL, pixel_y_dimension INT DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_6824FD753DA5256D (image_id), INDEX IDX_6824FD75B03A8386 (created_by_id), INDEX IDX_6824FD7599049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE establishment_means (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, label VARCHAR(64) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_540EB81DB03A8386 (created_by_id), INDEX IDX_540EB81D99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, start_date DATE DEFAULT NULL, end_date DATE DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_5387574A64D218E (location_id), INDEX IDX_5387574AB03A8386 (created_by_id), INDEX IDX_5387574A99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identifications (id INT AUTO_INCREMENT NOT NULL, occurrence_id INT DEFAULT NULL, taxon_id INT NOT NULL, identified_by_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, date_identified DATE DEFAULT NULL, identification_remarks LONGTEXT DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_65F654C430572FAC (occurrence_id), INDEX IDX_65F654C4DE13F470 (taxon_id), INDEX IDX_65F654C46AAB25CA (identified_by_id), INDEX IDX_65F654C4B03A8386 (created_by_id), INDEX IDX_65F654C499049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, occurrence_id INT DEFAULT NULL, identification_id INT NOT NULL, creator_id INT NOT NULL, license_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, source VARCHAR(255) DEFAULT NULL, dc_type VARCHAR(64) NOT NULL, subtype VARCHAR(64) NOT NULL, caption LONGTEXT DEFAULT NULL, subject_category VARCHAR(64) DEFAULT NULL, subject_part VARCHAR(64) DEFAULT NULL, subject_orientation VARCHAR(64) DEFAULT NULL, create_date DATE DEFAULT NULL, digitization_date DATE DEFAULT NULL, rights VARCHAR(255) DEFAULT NULL, is_hero_image TINYINT(1) DEFAULT NULL, rating SMALLINT DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_E01FBE6A30572FAC (occurrence_id), INDEX IDX_E01FBE6A4DFE3A85 (identification_id), INDEX IDX_E01FBE6A61220EA6 (creator_id), INDEX IDX_E01FBE6A460F904B (license_id), INDEX IDX_E01FBE6AB03A8386 (created_by_id), INDEX IDX_E01FBE6A99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_access_points (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, variant_id INT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, access_uri VARCHAR(128) NOT NULL, format VARCHAR(32) NOT NULL, pixel_x_dimension INT DEFAULT NULL, pixel_y_dimension INT DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_913FF9103DA5256D (image_id), INDEX IDX_913FF9103B69A9AF (variant_id), INDEX IDX_913FF910B03A8386 (created_by_id), INDEX IDX_913FF91099049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_variants (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, curie VARCHAR(32) NOT NULL, variant_literal VARCHAR(64) DEFAULT NULL, variant_description LONGTEXT DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_3C68DD49B03A8386 (created_by_id), INDEX IDX_3C68DD4999049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE license (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, label VARCHAR(32) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_5768F419B03A8386 (created_by_id), INDEX IDX_5768F41999049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, country VARCHAR(64) DEFAULT NULL, country_code VARCHAR(2) DEFAULT NULL, state_province VARCHAR(64) DEFAULT NULL, locality VARCHAR(255) DEFAULT NULL, decimal_longitude NUMERIC(10, 0) DEFAULT NULL, decimal_latitude NUMERIC(10, 0) DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_17E64ABAB03A8386 (created_by_id), INDEX IDX_17E64ABA99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE names (id INT AUTO_INCREMENT NOT NULL, protologue_id INT DEFAULT NULL, name_type_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, full_name VARCHAR(255) NOT NULL, authorship VARCHAR(255) NOT NULL, nomenclatural_note VARCHAR(255) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_F23349408924EEB2 (protologue_id), INDEX IDX_F2334940CD27C92D (name_type_id), INDEX IDX_F2334940B03A8386 (created_by_id), INDEX IDX_F233494099049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE name_type (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_CB688D5EB03A8386 (created_by_id), INDEX IDX_CB688D5E99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE occurrences (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, recorded_by_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, catalog_number VARCHAR(32) NOT NULL, record_number VARCHAR(32) DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_3F04912C71F7E88B (event_id), INDEX IDX_3F04912CD05A957B (recorded_by_id), INDEX IDX_3F04912CB03A8386 (created_by_id), INDEX IDX_3F04912C99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE occurrence_status (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, label VARCHAR(64) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_4F40C8E3B03A8386 (created_by_id), INDEX IDX_4F40C8E399049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `references` (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, reference VARCHAR(255) NOT NULL, author VARCHAR(128) DEFAULT NULL, publication_year VARCHAR(16) NOT NULL, title LONGTEXT NOT NULL, journal_or_book VARCHAR(128) DEFAULT NULL, collation VARCHAR(128) DEFAULT NULL, series VARCHAR(32) DEFAULT NULL, edition VARCHAR(32) DEFAULT NULL, volume VARCHAR(32) DEFAULT NULL, part VARCHAR(32) DEFAULT NULL, page VARCHAR(32) DEFAULT NULL, publisher VARCHAR(64) DEFAULT NULL, place_of_publication VARCHAR(64) DEFAULT NULL, subject VARCHAR(64) DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_9F1E2D9C727ACA70 (parent_id), INDEX IDX_9F1E2D9CB03A8386 (created_by_id), INDEX IDX_9F1E2D9C99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxa (id INT AUTO_INCREMENT NOT NULL, scientific_name_id INT NOT NULL, taxon_tree_def_item_id INT NOT NULL, accepted_name_usage_id INT DEFAULT NULL, parent_name_usage_id INT DEFAULT NULL, original_name_usage_id INT DEFAULT NULL, taxonomic_status_id INT DEFAULT NULL, occurrence_status_id INT DEFAULT NULL, establishment_means_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name_according_to VARCHAR(255) DEFAULT NULL, taxon_remarks LONGTEXT DEFAULT NULL, do_not_index TINYINT(1) DEFAULT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_515FEBF0E9F9049C (scientific_name_id), INDEX IDX_515FEBF0E05BC1D2 (taxon_tree_def_item_id), INDEX IDX_515FEBF016A803E7 (accepted_name_usage_id), INDEX IDX_515FEBF0D10770C6 (parent_name_usage_id), INDEX IDX_515FEBF0C2E0CA0B (original_name_usage_id), INDEX IDX_515FEBF0F3CFC345 (taxonomic_status_id), INDEX IDX_515FEBF0B81AB750 (occurrence_status_id), INDEX IDX_515FEBF0B91BFCF0 (establishment_means_id), INDEX IDX_515FEBF0B03A8386 (created_by_id), INDEX IDX_515FEBF099049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxonomic_status (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, label VARCHAR(64) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_7B3117B6B03A8386 (created_by_id), INDEX IDX_7B3117B699049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxon_tree_def_item (id INT AUTO_INCREMENT NOT NULL, parent_item_id INT DEFAULT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(64) NOT NULL, text_before VARCHAR(16) DEFAULT NULL, text_after VARCHAR(16) DEFAULT NULL, full_name_separator VARCHAR(4) DEFAULT NULL, is_enforced TINYINT(1) DEFAULT NULL, is_in_full_name TINYINT(1) DEFAULT NULL, rank_id SMALLINT NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, INDEX IDX_76EEA36B60272618 (parent_item_id), INDEX IDX_76EEA36BB03A8386 (created_by_id), INDEX IDX_76EEA36B99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, modified_by_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, timestamp_created DATETIME DEFAULT NULL, timestamp_modified DATETIME DEFAULT NULL, guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', version SMALLINT NOT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, INDEX IDX_1483A5E9B03A8386 (created_by_id), INDEX IDX_1483A5E999049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6EB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE agents ADD CONSTRAINT FK_9596AB6E99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE cumulus_images ADD CONSTRAINT FK_6824FD753DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE cumulus_images ADD CONSTRAINT FK_6824FD75B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE cumulus_images ADD CONSTRAINT FK_6824FD7599049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE establishment_means ADD CONSTRAINT FK_540EB81DB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE establishment_means ADD CONSTRAINT FK_540EB81D99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A64D218E FOREIGN KEY (location_id) REFERENCES locations (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574A99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE identifications ADD CONSTRAINT FK_65F654C430572FAC FOREIGN KEY (occurrence_id) REFERENCES occurrences (id)');
        $this->addSql('ALTER TABLE identifications ADD CONSTRAINT FK_65F654C4DE13F470 FOREIGN KEY (taxon_id) REFERENCES taxa (id)');
        $this->addSql('ALTER TABLE identifications ADD CONSTRAINT FK_65F654C46AAB25CA FOREIGN KEY (identified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE identifications ADD CONSTRAINT FK_65F654C4B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE identifications ADD CONSTRAINT FK_65F654C499049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A30572FAC FOREIGN KEY (occurrence_id) REFERENCES occurrences (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A4DFE3A85 FOREIGN KEY (identification_id) REFERENCES identifications (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A61220EA6 FOREIGN KEY (creator_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A460F904B FOREIGN KEY (license_id) REFERENCES license (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE image_access_points ADD CONSTRAINT FK_913FF9103DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE image_access_points ADD CONSTRAINT FK_913FF9103B69A9AF FOREIGN KEY (variant_id) REFERENCES image_variants (id)');
        $this->addSql('ALTER TABLE image_access_points ADD CONSTRAINT FK_913FF910B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE image_access_points ADD CONSTRAINT FK_913FF91099049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE image_variants ADD CONSTRAINT FK_3C68DD49B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE image_variants ADD CONSTRAINT FK_3C68DD4999049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F419B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE license ADD CONSTRAINT FK_5768F41999049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABAB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE names ADD CONSTRAINT FK_F23349408924EEB2 FOREIGN KEY (protologue_id) REFERENCES `references` (id)');
        $this->addSql('ALTER TABLE names ADD CONSTRAINT FK_F2334940CD27C92D FOREIGN KEY (name_type_id) REFERENCES name_type (id)');
        $this->addSql('ALTER TABLE names ADD CONSTRAINT FK_F2334940B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE names ADD CONSTRAINT FK_F233494099049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE name_type ADD CONSTRAINT FK_CB688D5EB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE name_type ADD CONSTRAINT FK_CB688D5E99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE occurrences ADD CONSTRAINT FK_3F04912C71F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE occurrences ADD CONSTRAINT FK_3F04912CD05A957B FOREIGN KEY (recorded_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE occurrences ADD CONSTRAINT FK_3F04912CB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE occurrences ADD CONSTRAINT FK_3F04912C99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE occurrence_status ADD CONSTRAINT FK_4F40C8E3B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE occurrence_status ADD CONSTRAINT FK_4F40C8E399049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE `references` ADD CONSTRAINT FK_9F1E2D9C727ACA70 FOREIGN KEY (parent_id) REFERENCES `references` (id)');
        $this->addSql('ALTER TABLE `references` ADD CONSTRAINT FK_9F1E2D9CB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE `references` ADD CONSTRAINT FK_9F1E2D9C99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0E9F9049C FOREIGN KEY (scientific_name_id) REFERENCES names (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0E05BC1D2 FOREIGN KEY (taxon_tree_def_item_id) REFERENCES taxon_tree_def_item (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF016A803E7 FOREIGN KEY (accepted_name_usage_id) REFERENCES taxa (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0D10770C6 FOREIGN KEY (parent_name_usage_id) REFERENCES taxa (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0C2E0CA0B FOREIGN KEY (original_name_usage_id) REFERENCES taxa (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0F3CFC345 FOREIGN KEY (taxonomic_status_id) REFERENCES taxonomic_status (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0B81AB750 FOREIGN KEY (occurrence_status_id) REFERENCES occurrence_status (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0B91BFCF0 FOREIGN KEY (establishment_means_id) REFERENCES establishment_means (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF0B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE taxa ADD CONSTRAINT FK_515FEBF099049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE taxonomic_status ADD CONSTRAINT FK_7B3117B6B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE taxonomic_status ADD CONSTRAINT FK_7B3117B699049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE taxon_tree_def_item ADD CONSTRAINT FK_76EEA36B60272618 FOREIGN KEY (parent_item_id) REFERENCES taxon_tree_def_item (id)');
        $this->addSql('ALTER TABLE taxon_tree_def_item ADD CONSTRAINT FK_76EEA36BB03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE taxon_tree_def_item ADD CONSTRAINT FK_76EEA36B99049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9B03A8386 FOREIGN KEY (created_by_id) REFERENCES agents (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E999049ECE FOREIGN KEY (modified_by_id) REFERENCES agents (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agents DROP FOREIGN KEY FK_9596AB6EB03A8386');
        $this->addSql('ALTER TABLE agents DROP FOREIGN KEY FK_9596AB6E99049ECE');
        $this->addSql('ALTER TABLE cumulus_images DROP FOREIGN KEY FK_6824FD75B03A8386');
        $this->addSql('ALTER TABLE cumulus_images DROP FOREIGN KEY FK_6824FD7599049ECE');
        $this->addSql('ALTER TABLE establishment_means DROP FOREIGN KEY FK_540EB81DB03A8386');
        $this->addSql('ALTER TABLE establishment_means DROP FOREIGN KEY FK_540EB81D99049ECE');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574AB03A8386');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A99049ECE');
        $this->addSql('ALTER TABLE identifications DROP FOREIGN KEY FK_65F654C46AAB25CA');
        $this->addSql('ALTER TABLE identifications DROP FOREIGN KEY FK_65F654C4B03A8386');
        $this->addSql('ALTER TABLE identifications DROP FOREIGN KEY FK_65F654C499049ECE');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A61220EA6');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AB03A8386');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A99049ECE');
        $this->addSql('ALTER TABLE image_access_points DROP FOREIGN KEY FK_913FF910B03A8386');
        $this->addSql('ALTER TABLE image_access_points DROP FOREIGN KEY FK_913FF91099049ECE');
        $this->addSql('ALTER TABLE image_variants DROP FOREIGN KEY FK_3C68DD49B03A8386');
        $this->addSql('ALTER TABLE image_variants DROP FOREIGN KEY FK_3C68DD4999049ECE');
        $this->addSql('ALTER TABLE license DROP FOREIGN KEY FK_5768F419B03A8386');
        $this->addSql('ALTER TABLE license DROP FOREIGN KEY FK_5768F41999049ECE');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABAB03A8386');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA99049ECE');
        $this->addSql('ALTER TABLE names DROP FOREIGN KEY FK_F2334940B03A8386');
        $this->addSql('ALTER TABLE names DROP FOREIGN KEY FK_F233494099049ECE');
        $this->addSql('ALTER TABLE name_type DROP FOREIGN KEY FK_CB688D5EB03A8386');
        $this->addSql('ALTER TABLE name_type DROP FOREIGN KEY FK_CB688D5E99049ECE');
        $this->addSql('ALTER TABLE occurrences DROP FOREIGN KEY FK_3F04912CD05A957B');
        $this->addSql('ALTER TABLE occurrences DROP FOREIGN KEY FK_3F04912CB03A8386');
        $this->addSql('ALTER TABLE occurrences DROP FOREIGN KEY FK_3F04912C99049ECE');
        $this->addSql('ALTER TABLE occurrence_status DROP FOREIGN KEY FK_4F40C8E3B03A8386');
        $this->addSql('ALTER TABLE occurrence_status DROP FOREIGN KEY FK_4F40C8E399049ECE');
        $this->addSql('ALTER TABLE `references` DROP FOREIGN KEY FK_9F1E2D9CB03A8386');
        $this->addSql('ALTER TABLE `references` DROP FOREIGN KEY FK_9F1E2D9C99049ECE');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0B03A8386');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF099049ECE');
        $this->addSql('ALTER TABLE taxonomic_status DROP FOREIGN KEY FK_7B3117B6B03A8386');
        $this->addSql('ALTER TABLE taxonomic_status DROP FOREIGN KEY FK_7B3117B699049ECE');
        $this->addSql('ALTER TABLE taxon_tree_def_item DROP FOREIGN KEY FK_76EEA36BB03A8386');
        $this->addSql('ALTER TABLE taxon_tree_def_item DROP FOREIGN KEY FK_76EEA36B99049ECE');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9B03A8386');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E999049ECE');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0B91BFCF0');
        $this->addSql('ALTER TABLE occurrences DROP FOREIGN KEY FK_3F04912C71F7E88B');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A4DFE3A85');
        $this->addSql('ALTER TABLE cumulus_images DROP FOREIGN KEY FK_6824FD753DA5256D');
        $this->addSql('ALTER TABLE image_access_points DROP FOREIGN KEY FK_913FF9103DA5256D');
        $this->addSql('ALTER TABLE image_access_points DROP FOREIGN KEY FK_913FF9103B69A9AF');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A460F904B');
        $this->addSql('ALTER TABLE events DROP FOREIGN KEY FK_5387574A64D218E');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0E9F9049C');
        $this->addSql('ALTER TABLE names DROP FOREIGN KEY FK_F2334940CD27C92D');
        $this->addSql('ALTER TABLE identifications DROP FOREIGN KEY FK_65F654C430572FAC');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A30572FAC');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0B81AB750');
        $this->addSql('ALTER TABLE names DROP FOREIGN KEY FK_F23349408924EEB2');
        $this->addSql('ALTER TABLE `references` DROP FOREIGN KEY FK_9F1E2D9C727ACA70');
        $this->addSql('ALTER TABLE identifications DROP FOREIGN KEY FK_65F654C4DE13F470');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF016A803E7');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0D10770C6');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0C2E0CA0B');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0F3CFC345');
        $this->addSql('ALTER TABLE taxa DROP FOREIGN KEY FK_515FEBF0E05BC1D2');
        $this->addSql('ALTER TABLE taxon_tree_def_item DROP FOREIGN KEY FK_76EEA36B60272618');
        $this->addSql('ALTER TABLE agents DROP FOREIGN KEY FK_9596AB6EA76ED395');
        $this->addSql('DROP TABLE agents');
        $this->addSql('DROP TABLE cumulus_images');
        $this->addSql('DROP TABLE establishment_means');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE identifications');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE image_access_points');
        $this->addSql('DROP TABLE image_variants');
        $this->addSql('DROP TABLE license');
        $this->addSql('DROP TABLE locations');
        $this->addSql('DROP TABLE names');
        $this->addSql('DROP TABLE name_type');
        $this->addSql('DROP TABLE occurrences');
        $this->addSql('DROP TABLE occurrence_status');
        $this->addSql('DROP TABLE `references`');
        $this->addSql('DROP TABLE taxa');
        $this->addSql('DROP TABLE taxonomic_status');
        $this->addSql('DROP TABLE taxon_tree_def_item');
        $this->addSql('DROP TABLE users');
    }
}
