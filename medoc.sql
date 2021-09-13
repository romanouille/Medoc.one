-- Adminer 4.8.1 PostgreSQL 11.12 (Debian 11.12-0+deb10u1) dump

DROP TABLE IF EXISTS "cis_bpdm";
DROP SEQUENCE IF EXISTS cis_bpdm_id_seq;
CREATE SEQUENCE cis_bpdm_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."cis_bpdm" (
    "id" bigint DEFAULT nextval('cis_bpdm_id_seq') NOT NULL,
    "name" text NOT NULL,
    "form" character(255) NOT NULL,
    "administration" character(255) NOT NULL,
    "administrative_status" character(255) NOT NULL,
    "authorization_procedure" character(255) NOT NULL,
    "status" character(255) NOT NULL,
    "amm" character(255) NOT NULL,
    "bdm_status" character(255) NOT NULL,
    "european_authorization" character(255) NOT NULL,
    "holders" character(255) NOT NULL,
    "surveillance" character(255) NOT NULL,
    CONSTRAINT "cis_bpdm_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX "cis_bpdm_name_idx" ON "public"."cis_bpdm" USING btree ("name");

CREATE INDEX "cis_bpdm_name_idx1" ON "public"."cis_bpdm" USING btree ("name");


DROP TABLE IF EXISTS "cis_cip_bpdm";
DROP SEQUENCE IF EXISTS cis_cip_bpdm_id_seq;
CREATE SEQUENCE cis_cip_bpdm_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."cis_cip_bpdm" (
    "id" bigint DEFAULT nextval('cis_cip_bpdm_id_seq') NOT NULL,
    "cis" character(255) NOT NULL,
    "cip7" character(255) NOT NULL,
    "presentation" character(255) NOT NULL,
    "administrative_status_of_presentation" character(255) NOT NULL,
    "marketing_status" character(255) NOT NULL,
    "marketing_date" character(255) NOT NULL,
    "cip13" bigint NOT NULL,
    "communities" character(255) NOT NULL,
    "refund" character(255) NOT NULL,
    "price" character(255) NOT NULL,
    "refund_policy" character(255) NOT NULL,
    "marketing_date_timestamp" bigint NOT NULL,
    CONSTRAINT "cis_cip_bpdm_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "cis_compo_bpdm";
DROP SEQUENCE IF EXISTS cis_compo_bpdm_id_seq;
CREATE SEQUENCE cis_compo_bpdm_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."cis_compo_bpdm" (
    "id" bigint DEFAULT nextval('cis_compo_bpdm_id_seq') NOT NULL,
    "cis" bigint NOT NULL,
    "type" character(255) NOT NULL,
    "substance_code" character(255) NOT NULL,
    "substance_name" text NOT NULL,
    "substance_dosage" character(255) NOT NULL,
    "dosage_reference" character(255) NOT NULL,
    "component_nature" character(255) NOT NULL,
    "link_number" bigint NOT NULL,
    CONSTRAINT "cis_compo_bpdm_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX "cis_compo_bpdm_substance_name_idx" ON "public"."cis_compo_bpdm" USING btree ("substance_name");

CREATE INDEX "cis_compo_bpdm_substance_name_idx1" ON "public"."cis_compo_bpdm" USING btree ("substance_name");


DROP TABLE IF EXISTS "comments";
DROP SEQUENCE IF EXISTS comments_id_seq;
CREATE SEQUENCE comments_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."comments" (
    "id" bigint DEFAULT nextval('comments_id_seq') NOT NULL,
    "source_ip" inet NOT NULL,
    "source_port" integer NOT NULL,
    "username" character(20) NOT NULL,
    "content" text NOT NULL,
    "cis" bigint NOT NULL,
    "timestamp" bigint NOT NULL,
    CONSTRAINT "comments_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "config";
DROP SEQUENCE IF EXISTS config_id_seq;
CREATE SEQUENCE config_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."config" (
    "id" bigint DEFAULT nextval('config_id_seq') NOT NULL,
    "name" character(100) NOT NULL,
    "value" character(100) NOT NULL,
    CONSTRAINT "config_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX "config_name" ON "public"."config" USING btree ("name");

INSERT INTO "config" ("id", "name", "value") VALUES
(1,	'maintenance                                                                                         ',	'0                                                                                                   ');

-- 2021-09-13 07:25:12.999735+00
