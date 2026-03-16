-- SQLite uses dynamic typing; no schema change required for cfg_type.

INSERT OR IGNORE INTO `config_cfg` (`cfg_id`, `cfg_name`, `cfg_value`, `cfg_type`, `cfg_default`, `cfg_tooltip`, `cfg_section`) VALUES
(1047, 'sChurchCountry', 'United States', 'country', '', 'Church Country', 'ChurchInfoReport');

-- SQLite DROP COLUMN support depends on version; skip to avoid rebuild.

-- SQLite does not support CHANGE COLUMN; integer affinity is dynamic.
