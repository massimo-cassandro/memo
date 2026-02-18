--
-- File generato con SQLiteStudio v3.4.17 su mer feb 18 22:31:08 2026
--
-- Codifica del testo utilizzata: UTF-8
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- Tabella: attachments
CREATE TABLE attachments (
    id             INTEGER     PRIMARY KEY AUTOINCREMENT,
    memo_id        INTEGER     REFERENCES memo (id) ON DELETE CASCADE
                               NOT NULL,
    gdrive_file_id VARCHAR     UNIQUE
                               DEFAULT NULL,
    filename       TEXT        NOT NULL,
    display_name   TEXT,
    caption        TEXT,
    mime           TEXT        NOT NULL,
    width          NUMERIC (5),
    height         NUMERIC (5),
    size           NUMERIC
);


-- Tabella: memo
CREATE TABLE memo (
    id           INTEGER       PRIMARY KEY AUTOINCREMENT
                               NOT NULL,
    title        VARCHAR (255) NOT NULL,
    search       TEXT          DEFAULT NULL,
    content      TEXT,
    is_encrypted BOOLEAN       NOT NULL
                               DEFAULT (0),
    favourite    BOOLEAN       NOT NULL
                               DEFAULT (0),
    archived     BOOLEAN       NOT NULL
                               DEFAULT (0),
    trash        BOOLEAN       DEFAULT (0)
                               NOT NULL,
    created      TEXT          DEFAULT (CURRENT_TIMESTAMP)
                               NOT NULL,
    updated      TEXT          DEFAULT (CURRENT_TIMESTAMP)
                               NOT NULL
);


-- Tabella: memo_tags
CREATE TABLE memo_tags (
    memo_id INTEGER REFERENCES memo (id) ON DELETE CASCADE,
    tag_id  INTEGER REFERENCES tags (id) ON DELETE CASCADE,
    PRIMARY KEY (
        memo_id,
        tag_id
    )
);


-- Tabella: tags
CREATE TABLE tags (
    id  INTEGER PRIMARY KEY AUTOINCREMENT
                NOT NULL,
    tag TEXT    NOT NULL
                UNIQUE
);


-- Indice: note_idx
CREATE INDEX note_idx ON attachments (
    memo_id ASC
);


-- Indice: title_idx
CREATE INDEX title_idx ON memo (
    title ASC
);


-- Trigger: update_timestamp
CREATE TRIGGER update_timestamp
         AFTER UPDATE
            ON memo
      FOR EACH ROW
          WHEN OLD.updated != DATETIME('NOW', 'localtime')
BEGIN
    UPDATE memo
       SET updated = DATETIME('now', 'localtime')
     WHERE id = new.id;
END;


COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
