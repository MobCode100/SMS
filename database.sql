CREATE USER sms_2r2mart IDENTIFIED BY "system"  ;
GRANT "DBA" TO sms_2r2mart ;

--------------------------------------------------------
--  File created - Wednesday-June-17-2020   
--------------------------------------------------------
--------------------------------------------------------
--  DDL for Sequence EMP_AUTOINC
--------------------------------------------------------

   CREATE SEQUENCE  "SMS_2R2MART"."EMP_AUTOINC"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 3 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence JOB_AUTOINC
--------------------------------------------------------

   CREATE SEQUENCE  "SMS_2R2MART"."JOB_AUTOINC"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 3 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence PRODUCT_AUTOINC
--------------------------------------------------------

   CREATE SEQUENCE  "SMS_2R2MART"."PRODUCT_AUTOINC"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence SUPPLIER_AUTOINC
--------------------------------------------------------

   CREATE SEQUENCE  "SMS_2R2MART"."SUPPLIER_AUTOINC"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Sequence TRANSACTION_AUTOINC
--------------------------------------------------------

   CREATE SEQUENCE  "SMS_2R2MART"."TRANSACTION_AUTOINC"  MINVALUE 1 MAXVALUE 9999999999999999999999999999 INCREMENT BY 1 START WITH 1 CACHE 20 NOORDER  NOCYCLE ;
--------------------------------------------------------
--  DDL for Table EMPLOYEE
--------------------------------------------------------

  CREATE TABLE "SMS_2R2MART"."EMPLOYEE" 
   (	"EMP_ID" NUMBER(11,0), 
	"NAME" VARCHAR2(256 BYTE), 
	"EMAIL" VARCHAR2(100 BYTE), 
	"ADDRESS" VARCHAR2(500 BYTE), 
	"PHONENO" VARCHAR2(20 BYTE), 
	"PASSWORD" VARCHAR2(16 BYTE), 
	"SALARY" NUMBER(10,2) DEFAULT 0, 
	"HIRE_DATE" DATE, 
	"JOB_ID" NUMBER(11,0), 
	"SUPERVISOR_ID" NUMBER(11,0) DEFAULT NULL
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table FULL_TIME
--------------------------------------------------------

  CREATE TABLE "SMS_2R2MART"."FULL_TIME" 
   (	"EMP_ID" NUMBER(11,0), 
	"ALLOWANCE" NUMBER(10,2) DEFAULT 0
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table JOB
--------------------------------------------------------

  CREATE TABLE "SMS_2R2MART"."JOB" 
   (	"JOB_ID" NUMBER(11,0), 
	"JOB_TITLE" VARCHAR2(20 BYTE), 
	"MIN_SALARY" NUMBER(10,2), 
	"MAX_SALARY" NUMBER(10,2)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table PART_TIME
--------------------------------------------------------

  CREATE TABLE "SMS_2R2MART"."PART_TIME" 
   (	"EMP_ID" NUMBER(11,0), 
	"HOURLY_RATE" NUMBER(10,2) DEFAULT 0
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table PRODUCT
--------------------------------------------------------

  CREATE TABLE "SMS_2R2MART"."PRODUCT" 
   (	"PRODUCT_ID" NUMBER(11,0), 
	"NAME" VARCHAR2(256 BYTE), 
	"DESCRIPTION" VARCHAR2(500 BYTE), 
	"PRICE" NUMBER(10,2), 
	"QUANTITY" NUMBER(5,0) DEFAULT 0, 
	"SUPPLIER_ID" NUMBER(11,0)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table SUPPLIER
--------------------------------------------------------

  CREATE TABLE "SMS_2R2MART"."SUPPLIER" 
   (	"SUPPLIER_ID" NUMBER(11,0), 
	"NAME" VARCHAR2(256 BYTE), 
	"DESCRIPTION" VARCHAR2(500 BYTE), 
	"ADDRESS" VARCHAR2(500 BYTE), 
	"CONTACT_NO" VARCHAR2(20 BYTE)
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Table TRANSACTION
--------------------------------------------------------

  CREATE TABLE "SMS_2R2MART"."TRANSACTION" 
   (	"TRANSACTION_ID" NUMBER(11,0), 
	"EMP_ID" NUMBER(11,0), 
	"PRODUCT_ID" NUMBER(11,0), 
	"QUANTITY" NUMBER(5,0), 
	"DATE_TIME" TIMESTAMP (6) DEFAULT SYSDATE
   ) SEGMENT CREATION IMMEDIATE 
  PCTFREE 10 PCTUSED 40 INITRANS 1 MAXTRANS 255 NOCOMPRESS LOGGING
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
REM INSERTING into SMS_2R2MART.EMPLOYEE
SET DEFINE OFF;
Insert into SMS_2R2MART.EMPLOYEE (EMP_ID,NAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID) values (1,'Ahmad Maslan','maslantodak@juv.na','kampung selamat','123','system',12.2,to_date('17/06/2020','DD/MM/RRRR'),1,null);
Insert into SMS_2R2MART.EMPLOYEE (EMP_ID,NAME,EMAIL,ADDRESS,PHONENO,PASSWORD,SALARY,HIRE_DATE,JOB_ID,SUPERVISOR_ID) values (2,'Kuruma','kurkur@gmail.ciom','kampung pishang','456','system',1111.11,to_date('17/06/2020','DD/MM/RRRR'),2,null);
REM INSERTING into SMS_2R2MART.FULL_TIME
SET DEFINE OFF;
REM INSERTING into SMS_2R2MART.JOB
SET DEFINE OFF;
Insert into SMS_2R2MART.JOB (JOB_ID,JOB_TITLE,MIN_SALARY,MAX_SALARY) values (1,'MANAGER',null,null);
Insert into SMS_2R2MART.JOB (JOB_ID,JOB_TITLE,MIN_SALARY,MAX_SALARY) values (2,'STAFF',null,null);
REM INSERTING into SMS_2R2MART.PART_TIME
SET DEFINE OFF;
REM INSERTING into SMS_2R2MART.PRODUCT
SET DEFINE OFF;
REM INSERTING into SMS_2R2MART.SUPPLIER
SET DEFINE OFF;
REM INSERTING into SMS_2R2MART.TRANSACTION
SET DEFINE OFF;
--------------------------------------------------------
--  DDL for Index PK_TRANSACTION
--------------------------------------------------------

  CREATE UNIQUE INDEX "SMS_2R2MART"."PK_TRANSACTION" ON "SMS_2R2MART"."TRANSACTION" ("TRANSACTION_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index PK_EMPLOYEE
--------------------------------------------------------

  CREATE UNIQUE INDEX "SMS_2R2MART"."PK_EMPLOYEE" ON "SMS_2R2MART"."EMPLOYEE" ("EMP_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index PK_SUPPLIER
--------------------------------------------------------

  CREATE UNIQUE INDEX "SMS_2R2MART"."PK_SUPPLIER" ON "SMS_2R2MART"."SUPPLIER" ("SUPPLIER_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index PK_PRODUCT
--------------------------------------------------------

  CREATE UNIQUE INDEX "SMS_2R2MART"."PK_PRODUCT" ON "SMS_2R2MART"."PRODUCT" ("PRODUCT_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index PK_JOB
--------------------------------------------------------

  CREATE UNIQUE INDEX "SMS_2R2MART"."PK_JOB" ON "SMS_2R2MART"."JOB" ("JOB_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index PK_FULLTIME
--------------------------------------------------------

  CREATE UNIQUE INDEX "SMS_2R2MART"."PK_FULLTIME" ON "SMS_2R2MART"."FULL_TIME" ("EMP_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Index PK_PARTTIME
--------------------------------------------------------

  CREATE UNIQUE INDEX "SMS_2R2MART"."PK_PARTTIME" ON "SMS_2R2MART"."PART_TIME" ("EMP_ID") 
  PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM" ;
--------------------------------------------------------
--  DDL for Trigger EMP_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SMS_2R2MART"."EMP_TRG" 
BEFORE INSERT ON "SMS_2R2MART"."EMPLOYEE" 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.EMP_ID IS NULL THEN
      SELECT EMP_AUTOINC.NEXTVAL INTO :NEW.EMP_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "SMS_2R2MART"."EMP_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger JOB_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SMS_2R2MART"."JOB_TRG" 
BEFORE INSERT ON "SMS_2R2MART"."JOB" 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.JOB_ID IS NULL THEN
      SELECT JOB_AUTOINC.NEXTVAL INTO :NEW.JOB_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "SMS_2R2MART"."JOB_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger PRODUCT_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SMS_2R2MART"."PRODUCT_TRG" 
BEFORE INSERT ON "SMS_2R2MART"."PRODUCT" 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.PRODUCT_ID IS NULL THEN
      SELECT PRODUCT_AUTOINC.NEXTVAL INTO :NEW.PRODUCT_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "SMS_2R2MART"."PRODUCT_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger SUPPLIER_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SMS_2R2MART"."SUPPLIER_TRG" 
BEFORE INSERT ON "SMS_2R2MART"."SUPPLIER" 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.SUPPLIER_ID IS NULL THEN
      SELECT SUPPLIER_AUTOINC.NEXTVAL INTO :NEW.SUPPLIER_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "SMS_2R2MART"."SUPPLIER_TRG" ENABLE;
--------------------------------------------------------
--  DDL for Trigger TRANSACTION_TRG
--------------------------------------------------------

  CREATE OR REPLACE TRIGGER "SMS_2R2MART"."TRANSACTION_TRG" 
BEFORE INSERT ON "SMS_2R2MART"."TRANSACTION" 
FOR EACH ROW 
BEGIN
  <<COLUMN_SEQUENCES>>
  BEGIN
    IF INSERTING AND :NEW.TRANSACTION_ID IS NULL THEN
      SELECT TRANSACTION_AUTOINC.NEXTVAL INTO :NEW.TRANSACTION_ID FROM SYS.DUAL;
    END IF;
  END COLUMN_SEQUENCES;
END;

/
ALTER TRIGGER "SMS_2R2MART"."TRANSACTION_TRG" ENABLE;
--------------------------------------------------------
--  Constraints for Table PART_TIME
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."PART_TIME" ADD CONSTRAINT "PK_PARTTIME" PRIMARY KEY ("EMP_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SMS_2R2MART"."PART_TIME" MODIFY ("HOURLY_RATE" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table EMPLOYEE
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" ADD CONSTRAINT "PK_EMPLOYEE" PRIMARY KEY ("EMP_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("JOB_ID" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("HIRE_DATE" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("SALARY" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("PASSWORD" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("PHONENO" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("ADDRESS" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("EMAIL" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" MODIFY ("NAME" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table FULL_TIME
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."FULL_TIME" ADD CONSTRAINT "PK_FULLTIME" PRIMARY KEY ("EMP_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SMS_2R2MART"."FULL_TIME" MODIFY ("ALLOWANCE" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table SUPPLIER
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."SUPPLIER" ADD CONSTRAINT "PK_SUPPLIER" PRIMARY KEY ("SUPPLIER_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SMS_2R2MART"."SUPPLIER" MODIFY ("CONTACT_NO" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."SUPPLIER" MODIFY ("ADDRESS" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."SUPPLIER" MODIFY ("NAME" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."SUPPLIER" MODIFY ("SUPPLIER_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table TRANSACTION
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."TRANSACTION" ADD CONSTRAINT "PK_TRANSACTION" PRIMARY KEY ("TRANSACTION_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SMS_2R2MART"."TRANSACTION" MODIFY ("DATE_TIME" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."TRANSACTION" MODIFY ("QUANTITY" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."TRANSACTION" MODIFY ("PRODUCT_ID" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."TRANSACTION" MODIFY ("EMP_ID" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."TRANSACTION" MODIFY ("TRANSACTION_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table PRODUCT
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."PRODUCT" ADD CONSTRAINT "PK_PRODUCT" PRIMARY KEY ("PRODUCT_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SMS_2R2MART"."PRODUCT" MODIFY ("SUPPLIER_ID" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."PRODUCT" MODIFY ("QUANTITY" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."PRODUCT" MODIFY ("PRICE" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."PRODUCT" MODIFY ("NAME" NOT NULL ENABLE);
  ALTER TABLE "SMS_2R2MART"."PRODUCT" MODIFY ("PRODUCT_ID" NOT NULL ENABLE);
--------------------------------------------------------
--  Constraints for Table JOB
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."JOB" ADD CONSTRAINT "PK_JOB" PRIMARY KEY ("JOB_ID")
  USING INDEX PCTFREE 10 INITRANS 2 MAXTRANS 255 
  STORAGE(INITIAL 65536 NEXT 1048576 MINEXTENTS 1 MAXEXTENTS 2147483645
  PCTINCREASE 0 FREELISTS 1 FREELIST GROUPS 1 BUFFER_POOL DEFAULT FLASH_CACHE DEFAULT CELL_FLASH_CACHE DEFAULT)
  TABLESPACE "SYSTEM"  ENABLE;
  ALTER TABLE "SMS_2R2MART"."JOB" MODIFY ("JOB_TITLE" NOT NULL ENABLE);
--------------------------------------------------------
--  Ref Constraints for Table EMPLOYEE
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" ADD CONSTRAINT "FK_JOB" FOREIGN KEY ("JOB_ID")
	  REFERENCES "SMS_2R2MART"."JOB" ("JOB_ID") ENABLE;
  ALTER TABLE "SMS_2R2MART"."EMPLOYEE" ADD CONSTRAINT "FK_SUPERVISOR" FOREIGN KEY ("SUPERVISOR_ID")
	  REFERENCES "SMS_2R2MART"."EMPLOYEE" ("EMP_ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table FULL_TIME
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."FULL_TIME" ADD CONSTRAINT "FK_EMP_FT" FOREIGN KEY ("EMP_ID")
	  REFERENCES "SMS_2R2MART"."EMPLOYEE" ("EMP_ID") ON DELETE CASCADE ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table PART_TIME
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."PART_TIME" ADD CONSTRAINT "FK_EMP_PT" FOREIGN KEY ("EMP_ID")
	  REFERENCES "SMS_2R2MART"."EMPLOYEE" ("EMP_ID") ON DELETE CASCADE ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table PRODUCT
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."PRODUCT" ADD CONSTRAINT "FK_SUPPLIER" FOREIGN KEY ("SUPPLIER_ID")
	  REFERENCES "SMS_2R2MART"."SUPPLIER" ("SUPPLIER_ID") ENABLE;
--------------------------------------------------------
--  Ref Constraints for Table TRANSACTION
--------------------------------------------------------

  ALTER TABLE "SMS_2R2MART"."TRANSACTION" ADD CONSTRAINT "FK_EMP_TRS" FOREIGN KEY ("EMP_ID")
	  REFERENCES "SMS_2R2MART"."EMPLOYEE" ("EMP_ID") ENABLE;
  ALTER TABLE "SMS_2R2MART"."TRANSACTION" ADD CONSTRAINT "FK_PRODUCT_TRS" FOREIGN KEY ("PRODUCT_ID")
	  REFERENCES "SMS_2R2MART"."PRODUCT" ("PRODUCT_ID") ENABLE;
