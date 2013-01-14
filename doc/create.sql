SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `6board` ;
CREATE SCHEMA IF NOT EXISTS `6board` DEFAULT CHARACTER SET utf8 ;
USE `6board` ;

-- -----------------------------------------------------
-- Table `6board`.`project`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`project` ;

CREATE  TABLE IF NOT EXISTS `6board`.`project` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `project_group_id` INT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`user` ;

CREATE  TABLE IF NOT EXISTS `6board`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(45) NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `firstname` VARCHAR(255) NOT NULL ,
  `phone` VARCHAR(45) NULL ,
  `jabber_id` VARCHAR(255) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`story`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`story` ;

CREATE  TABLE IF NOT EXISTS `6board`.`story` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL ,
  `owner_user_id` INT NOT NULL ,
  `dev_user_id` INT NULL ,
  `status` ENUM('new', 'valid', 'in progress', 'closed') NOT NULL ,
  `due_date` DATETIME NULL ,
  `complexity` TINYINT NULL ,
  `closed_for` ENUM('resolved', 'invalid', 'wont be resolved', 'duplicate', 'unreproducible') NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  `type` ENUM('major', 'minor', 'alert', 'feature') NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_story_user1_idx` (`owner_user_id` ASC) ,
  INDEX `fk_story_user2_idx` (`dev_user_id` ASC) ,
  CONSTRAINT `fk_story_user1`
    FOREIGN KEY (`owner_user_id` )
    REFERENCES `6board`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_story_user2`
    FOREIGN KEY (`dev_user_id` )
    REFERENCES `6board`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`note`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`note` ;

CREATE  TABLE IF NOT EXISTS `6board`.`note` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `story_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `note` TEXT NULL COMMENT 'relation entre les story' ,
  `created_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_notes_story1_idx` (`story_id` ASC) ,
  INDEX `fk_notes_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_notes_story1`
    FOREIGN KEY (`story_id` )
    REFERENCES `6board`.`story` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notes_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `6board`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`note_file`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`note_file` ;

CREATE  TABLE IF NOT EXISTS `6board`.`note_file` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `notes_id` INT NOT NULL ,
  `name` VARCHAR(255) NULL ,
  `description` VARCHAR(255) NULL ,
  `path` TEXT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_files_notes1_idx` (`notes_id` ASC) ,
  CONSTRAINT `fk_files_notes1`
    FOREIGN KEY (`notes_id` )
    REFERENCES `6board`.`note` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`milestone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`milestone` ;

CREATE  TABLE IF NOT EXISTS `6board`.`milestone` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `project_id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `description` TEXT NULL ,
  `due_date` DATETIME NULL ,
  `status` ENUM('open', 'closed') NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_milestone_project1_idx` (`project_id` ASC) ,
  CONSTRAINT `fk_milestone_project1`
    FOREIGN KEY (`project_id` )
    REFERENCES `6board`.`project` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`note_commit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`note_commit` ;

CREATE  TABLE IF NOT EXISTS `6board`.`note_commit` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `url` TEXT NOT NULL ,
  `notes_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_commits_notes1_idx` (`notes_id` ASC) ,
  CONSTRAINT `fk_commits_notes1`
    FOREIGN KEY (`notes_id` )
    REFERENCES `6board`.`note` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`story_has_milestone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`story_has_milestone` ;

CREATE  TABLE IF NOT EXISTS `6board`.`story_has_milestone` (
  `story_id` INT NOT NULL ,
  `milestone_id` INT NOT NULL ,
  `position` INT NULL ,
  PRIMARY KEY (`story_id`, `milestone_id`) ,
  INDEX `fk_story_has_milestone_milestone1_idx` (`milestone_id` ASC) ,
  INDEX `fk_story_has_milestone_story1_idx` (`story_id` ASC) ,
  CONSTRAINT `fk_story_has_milestone_story1`
    FOREIGN KEY (`story_id` )
    REFERENCES `6board`.`story` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_story_has_milestone_milestone1`
    FOREIGN KEY (`milestone_id` )
    REFERENCES `6board`.`milestone` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`story_has_story`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`story_has_story` ;

CREATE  TABLE IF NOT EXISTS `6board`.`story_has_story` (
  `story_id_from` INT NOT NULL ,
  `story_id_to` INT NOT NULL ,
  `description` VARCHAR(255) NULL ,
  PRIMARY KEY (`story_id_from`, `story_id_to`) ,
  INDEX `fk_story_has_story_story2_idx` (`story_id_to` ASC) ,
  INDEX `fk_story_has_story_story1_idx` (`story_id_from` ASC) ,
  CONSTRAINT `fk_story_has_story_story1`
    FOREIGN KEY (`story_id_from` )
    REFERENCES `6board`.`story` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_story_has_story_story2`
    FOREIGN KEY (`story_id_to` )
    REFERENCES `6board`.`story` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`note_status_change`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`note_status_change` ;

CREATE  TABLE IF NOT EXISTS `6board`.`note_status_change` (
  `status_from` VARCHAR(45) NOT NULL ,
  `status_to` VARCHAR(45) NOT NULL ,
  `note_id` INT NOT NULL ,
  PRIMARY KEY (`note_id`) ,
  INDEX `fk_note_status_change_note1_idx` (`note_id` ASC) ,
  CONSTRAINT `fk_note_status_change_note1`
    FOREIGN KEY (`note_id` )
    REFERENCES `6board`.`note` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`search`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`search` ;

CREATE  TABLE IF NOT EXISTS `6board`.`search` (
  `id` INT NOT NULL COMMENT '		' ,
  `search` TEXT NOT NULL ,
  `public` TINYINT(1) NOT NULL DEFAULT 0 ,
  `user_id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`, `user_id`) ,
  INDEX `fk_search_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_search_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `6board`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`tag` ;

CREATE  TABLE IF NOT EXISTS `6board`.`tag` (
  `id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`story_has_tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`story_has_tag` ;

CREATE  TABLE IF NOT EXISTS `6board`.`story_has_tag` (
  `story_id` INT NOT NULL ,
  `tag_id` INT NOT NULL ,
  PRIMARY KEY (`story_id`, `tag_id`) ,
  INDEX `fk_story_has_tag_tag1_idx` (`tag_id` ASC) ,
  INDEX `fk_story_has_tag_story1_idx` (`story_id` ASC) ,
  CONSTRAINT `fk_story_has_tag_story1`
    FOREIGN KEY (`story_id` )
    REFERENCES `6board`.`story` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_story_has_tag_tag1`
    FOREIGN KEY (`tag_id` )
    REFERENCES `6board`.`tag` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `6board`.`milestone_has_autoaddmilestone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `6board`.`milestone_has_autoaddmilestone` ;

CREATE  TABLE IF NOT EXISTS `6board`.`milestone_has_autoaddmilestone` (
  `milestone_id` INT NOT NULL ,
  `milestone_id1` INT NOT NULL ,
  PRIMARY KEY (`milestone_id`, `milestone_id1`) ,
  INDEX `fk_milestone_has_milestone_milestone2_idx` (`milestone_id1` ASC) ,
  INDEX `fk_milestone_has_milestone_milestone1_idx` (`milestone_id` ASC) ,
  CONSTRAINT `fk_milestone_has_milestone_milestone1`
    FOREIGN KEY (`milestone_id` )
    REFERENCES `6board`.`milestone` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_milestone_has_milestone_milestone2`
    FOREIGN KEY (`milestone_id1` )
    REFERENCES `6board`.`milestone` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
