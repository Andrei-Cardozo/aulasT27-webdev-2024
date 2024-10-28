CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE respostas (
    id SERIAL PRIMARY KEY,
    id_pergunta INT NOT NULL,
    avaliacao INT NOT NULL CHECK (avaliacao >= 0 AND avaliacao <= 10),
    feedback TEXT,
    FOREIGN KEY (id_pergunta) REFERENCES perguntas(id) ON DELETE CASCADE
);
CREATE TABLE tablets (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    status VARCHAR(10) DEFAULT 'ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE setores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS tablets (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    status VARCHAR(10) DEFAULT 'ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

SELECT * FROM perguntas 

UPDATE perguntas SET status = FALSE WHERE id = 1;

ALTER TABLE perguntas ADD COLUMN status BOOLEAN DEFAULT TRUE;

SELECT column_name, data_type 
FROM information_schema.columns 
WHERE table_name = 'perguntas';



ALTER TABLE tablets ADD COLUMN local VARCHAR(255);


SELECT * FROM tablets


ALTER TABLE tablets
ADD COLUMN setor_id INTEGER REFERENCES setores(id);


SELECT * FROM tablets

CREATE TABLE setores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE
);

SELECT * FROM tablets
ALTER TABLE tablets RENAME COLUMN created_at TO criado_em;

ALTER TABLE setores ADD COLUMN ativo BOOLEAN DEFAULT TRUE;

SELECT * FROM setores

ALTER TABLE tablets
DROP CONSTRAINT tablets_setor_id_fkey,
ADD CONSTRAINT tablets_setor_id_fkey FOREIGN KEY (setor_id) REFERENCES setores(id) ON DELETE CASCADE;


SELECT * FROM respostas

ALTER TABLE respostas
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

ALTER TABLE respostas ADD COLUMN setor_id INT;  -- ou o tipo adequado


