SET FOREIGN_KEY_CHECKS = 0;

--
-- Table structure for table categories
--

DROP TABLE IF EXISTS category;
CREATE TABLE category (
  id INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  hex_color VARCHAR(255) NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table teams
--

DROP TABLE IF EXISTS team;
CREATE TABLE team (
  id INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  _category_id INT UNSIGNED NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (_category_id) REFERENCES category(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table events
--

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT UNSIGNED NOT NULL UNIQUE AUTO_INCREMENT,
  date timestamp NOT NULL,
  _category_id INT UNSIGNED NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_AT timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (_category_id) REFERENCES category(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table events
--

DROP TABLE IF EXISTS events_teams;
CREATE TABLE events_teams (
  _events_id INT UNSIGNED NOT NULL ,
  _home_team_id INT UNSIGNED NOT NULL,
  _away_team_id INT UNSIGNED NOT NULL,
  FOREIGN KEY (_event_id) REFERENCES events(id) ON DELETE CASCADE,
  FOREIGN KEY (_home_team_id) REFERENCES team(id) ON DELETE CASCADE,
  FOREIGN KEY (_away_team_id) REFERENCES team(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;