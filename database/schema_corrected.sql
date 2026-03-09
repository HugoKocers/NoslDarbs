-- CardQuest Game Database Schema (Corrected & Aligned with Laravel Implementation)
-- MySQL InnoDB Engine
-- Latvian naming convention with proper structure

-- ============================================================================
-- TABLE: Persona (Base Identity)
-- ============================================================================
CREATE TABLE Persona (
  personasID INT AUTO_INCREMENT PRIMARY KEY,
  lietotajvards VARCHAR(100) NOT NULL UNIQUE,
  epasts VARCHAR(100) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  COMMENT = 'Tabula glabā pamata personīgo informāciju - lietotājvārdu un e-pastu'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: Lietotajs (User Profile - extends Persona with auth/status)
-- ============================================================================
CREATE TABLE Lietotajs (
  lietotajsID INT AUTO_INCREMENT PRIMARY KEY,
  personasID INT NOT NULL UNIQUE,
  parole VARCHAR(255) NOT NULL,
  regDatums DATETIME NOT NULL,
  statuss VARCHAR(20) DEFAULT 'aktīvs',
  loma VARCHAR(20) DEFAULT 'lietotajs',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (personasID) REFERENCES Persona(personasID) ON DELETE CASCADE,
  COMMENT = 'Tabula glabā autentifikācijas datus un lietotāja stāvokli'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: Karts (Cards in the game)
-- ============================================================================
CREATE TABLE Karts (
  kartisID INT AUTO_INCREMENT PRIMARY KEY,
  nosaukums VARCHAR(100) NOT NULL,
  apraksts TEXT,
  vertiba INT NOT NULL,
  speks INT NOT NULL DEFAULT 1,
  maksa INT NOT NULL DEFAULT 1,
  elements VARCHAR(20),
  raritate VARCHAR(20),
  bilde_url VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  COMMENT = 'Tabula glabā spēles karšu informāciju - nosaukumu, vērtību, spēka un izmaksas parametrus'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: Dekas (Decks - collections of cards)
-- ============================================================================
CREATE TABLE Dekas (
  dekasID INT AUTO_INCREMENT PRIMARY KEY,
  lietotajsID INT NOT NULL,
  nosaukums VARCHAR(100) NOT NULL,
  apraksts TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (lietotajsID) REFERENCES Lietotajs(lietotajsID) ON DELETE CASCADE,
  COMMENT = 'Tabula glabā spēlētāju dekas (karšu kolekcijas)'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: LietotajsKartis (M:N Junction - Users have Cards)
-- ============================================================================
CREATE TABLE LietotajsKartis (
  lietotajsID INT NOT NULL,
  kartisID INT NOT NULL,
  skaits INT DEFAULT 1,
  acquired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (lietotajsID, kartisID),
  FOREIGN KEY (lietotajsID) REFERENCES Lietotajs(lietotajsID) ON DELETE CASCADE,
  FOREIGN KEY (kartisID) REFERENCES Karts(kartisID) ON DELETE CASCADE,
  COMMENT = 'Tabula realizē attiecību starp lietotājiem un viņu kartēm'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: DekaKartis (M:N Junction - Decks contain Cards)
-- ============================================================================
CREATE TABLE DekaKartis (
  dekasID INT NOT NULL,
  kartisID INT NOT NULL,
  skaits INT DEFAULT 1,
  PRIMARY KEY (dekasID, kartisID),
  FOREIGN KEY (dekasID) REFERENCES Dekas(dekasID) ON DELETE CASCADE,
  FOREIGN KEY (kartisID) REFERENCES Karts(kartisID) ON DELETE CASCADE,
  COMMENT = 'Tabula realizē attiecību starp dekām un kartēm'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: Kauja (Game Battle Session)
-- ============================================================================
CREATE TABLE Kauja (
  kaujas_ID INT AUTO_INCREMENT PRIMARY KEY,
  lietotajsID INT NOT NULL,
  pretiniekID INT,
  sakuma_laiks DATETIME NOT NULL,
  beigu_laiks DATETIME,
  stavoklis VARCHAR(20) DEFAULT 'aktīva',
  punkti_ieguti INT DEFAULT 0,
  uzvaras INT DEFAULT 0,
  zaudejumi INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (lietotajsID) REFERENCES Lietotajs(lietotajsID) ON DELETE CASCADE,
  FOREIGN KEY (pretiniekID) REFERENCES Lietotajs(lietotajsID) ON DELETE SET NULL,
  COMMENT = 'Tabula glabā informāciju par spēles sesinājumiem - sākuma laiku, beigu laiku, stāvokli un punktus'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: KaujaKartis (M:N Junction - Battle uses Cards)
-- ============================================================================
CREATE TABLE KaujaKartis (
  kaujas_ID INT NOT NULL,
  kartisID INT NOT NULL,
  apversanas_laiks DATETIME,
  ieguti_punkti INT DEFAULT 0,
  PRIMARY KEY (kaujas_ID, kartisID),
  FOREIGN KEY (kaujas_ID) REFERENCES Kauja(kaujas_ID) ON DELETE CASCADE,
  FOREIGN KEY (kartisID) REFERENCES Karts(kartisID) ON DELETE CASCADE,
  COMMENT = 'Tabula glabā saites starp kaujas sesinājumiem un kartēm, tostarp apversanas laiku un iegūtos punktus'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: SpelIeraksts (Game Record - Historical data for completed games)
-- ============================================================================
CREATE TABLE SpelIeraksts (
  ieraksta_ID INT AUTO_INCREMENT PRIMARY KEY,
  lietotajsID INT NOT NULL,
  kaujas_ID INT,
  datums DATETIME NOT NULL,
  punkti INT NOT NULL,
  rezultats VARCHAR(20),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (lietotajsID) REFERENCES Lietotajs(lietotajsID) ON DELETE CASCADE,
  FOREIGN KEY (kaujas_ID) REFERENCES Kauja(kaujas_ID) ON DELETE SET NULL,
  COMMENT = 'Vājā entītija - tabula glabā vēsturiskus datus par pabeigtām spēlēm analīzei un statistikai'
) ENGINE = InnoDB;

-- ============================================================================
-- TABLE: LideruSaraksts (Leaderboard - Rankings)
-- ============================================================================
CREATE TABLE LideruSaraksts (
  rangu_ID INT AUTO_INCREMENT PRIMARY KEY,
  lietotajsID INT NOT NULL UNIQUE,
  vietasNumurs INT NOT NULL UNIQUE,
  kopejie_punkti INT DEFAULT 0,
  uzvaras INT DEFAULT 0,
  zaudejumi INT DEFAULT 0,
  winrate DECIMAL(5,2) DEFAULT 0.00,
  datums DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  rangs VARCHAR(30),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (lietotajsID) REFERENCES Lietotajs(lietotajsID) ON DELETE CASCADE,
  COMMENT = 'Tabula glabā spēlētāju rangus un punktus - tiek atjaunināta regulāri'
) ENGINE = InnoDB;

-- ============================================================================
-- INDEXES for Performance
-- ============================================================================
CREATE INDEX idx_lietotajs_persona ON Lietotajs(personasID);
CREATE INDEX idx_karts_elements ON Karts(elements);
CREATE INDEX idx_karts_raritate ON Karts(raritate);
CREATE INDEX idx_lietotajskartis_lietotajs ON LietotajsKartis(lietotajsID);
CREATE INDEX idx_lietotajskartis_kartis ON LietotajsKartis(kartisID);
CREATE INDEX idx_dekas_lietotajs ON Dekas(lietotajsID);
CREATE INDEX idx_dekakartis_dekas ON DekaKartis(dekasID);
CREATE INDEX idx_kauja_lietotajs ON Kauja(lietotajsID);
CREATE INDEX idx_kauja_pretiniek ON Kauja(pretiniekID);
CREATE INDEX idx_kaujakartis_kauja ON KaujaKartis(kaujas_ID);
CREATE INDEX idx_spelieraksts_lietotajs ON SpelIeraksts(lietotajsID);
CREATE INDEX idx_spelieraksts_datums ON SpelIeraksts(datums);
CREATE INDEX idx_lidersaraksts_vieta ON LideruSaraksts(vietasNumurs);
CREATE INDEX idx_lidersaraksts_punkti ON LideruSaraksts(kopejie_punkti);
