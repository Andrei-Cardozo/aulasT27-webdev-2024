--Tabelas criadas:
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    setor_id INT,  -- ou o tipo adequado
    FOREIGN KEY (id_pergunta) REFERENCES perguntas(id) ON DELETE CASCADE
);

CREATE TABLE setores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL UNIQUE,
    ativo BOOLEAN DEFAULT TRUE
);

CREATE TABLE usuarios_admin (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE TABLE IF NOT EXISTS tablets (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    status VARCHAR(10) DEFAULT 'ativo',
    local VARCHAR(255),
    setor_id INTEGER REFERENCES setores(id) ON DELETE CASCADE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


--Alterações nas tabelas:

-- Atualiza o status de uma pergunta específica
UPDATE perguntas SET status = FALSE WHERE id = 1;

-- Adiciona a coluna 'status' à tabela 'perguntas'
ALTER TABLE perguntas ADD COLUMN status BOOLEAN DEFAULT TRUE;

-- Adiciona a coluna 'local' à tabela 'tablets'
ALTER TABLE tablets ADD COLUMN local VARCHAR(255);

-- Adiciona a coluna 'setor_id' à tabela 'tablets'
ALTER TABLE tablets ADD COLUMN setor_id INTEGER REFERENCES setores(id);

-- Renomeia a coluna 'created_at' para 'criado_em' na tabela 'tablets'
ALTER TABLE tablets RENAME COLUMN created_at TO criado_em;

-- Adiciona a coluna 'ativo' à tabela 'setores'
ALTER TABLE setores ADD COLUMN ativo BOOLEAN DEFAULT TRUE;

-- Remove e adiciona novamente a chave estrangeira 'setor_id' na tabela 'tablets'
ALTER TABLE tablets
DROP CONSTRAINT tablets_setor_id_fkey,
ADD CONSTRAINT tablets_setor_id_fkey FOREIGN KEY (setor_id) REFERENCES setores(id) ON DELETE CASCADE;

-- Adiciona a coluna 'created_at' à tabela 'respostas'
ALTER TABLE respostas ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Adiciona a coluna 'setor_id' à tabela 'respostas'
ALTER TABLE respostas ADD COLUMN setor_id INT; 


--Consultas:
SELECT * FROM perguntas;

SELECT * FROM tablets;

SELECT * FROM respostas;

SELECT * FROM setores;

-- Seleciona nome e tipo de dado das colunas da tabela 'perguntas'
SELECT column_name, data_type 
FROM information_schema.columns 
WHERE table_name = 'perguntas';
