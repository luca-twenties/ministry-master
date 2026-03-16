ALTER TABLE user_usr ADD COLUMN usr_TwoFactorAuthSecret VARCHAR(255) NULL;
ALTER TABLE user_usr ADD COLUMN usr_TwoFactorAuthLastKeyTimestamp INTEGER NULL;
ALTER TABLE user_usr ADD COLUMN usr_TwoFactorAuthRecoveryCodes TEXT NULL;
