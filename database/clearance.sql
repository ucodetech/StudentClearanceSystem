BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "cache" (
	"key"	varchar NOT NULL,
	"value"	text NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "cache_locks" (
	"key"	varchar NOT NULL,
	"owner"	varchar NOT NULL,
	"expiration"	integer NOT NULL,
	PRIMARY KEY("key")
);
CREATE TABLE IF NOT EXISTS "clearance_requests" (
	"id"	integer NOT NULL,
	"student_id"	integer NOT NULL,
	"status"	varchar NOT NULL DEFAULT 'processing' CHECK("status" IN ('approved', 'rejected', 'processing')),
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("student_id") REFERENCES "users"("id")
);
CREATE TABLE IF NOT EXISTS "desks" (
	"id"	integer NOT NULL,
	"staff_id"	integer NOT NULL,
	"request_id"	integer NOT NULL,
	"flow"	varchar NOT NULL CHECK("flow" IN ('admin', 'department', 'court', 'student_affairs')),
	"sort"	integer NOT NULL,
	"HasWork"	tinyint(1) NOT NULL DEFAULT '0',
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("request_id") REFERENCES "clearance_requests"("id"),
	FOREIGN KEY("staff_id") REFERENCES "users"("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs" (
	"id"	integer NOT NULL,
	"uuid"	varchar NOT NULL,
	"connection"	text NOT NULL,
	"queue"	text NOT NULL,
	"payload"	text NOT NULL,
	"exception"	text NOT NULL,
	"failed_at"	datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "job_batches" (
	"id"	varchar NOT NULL,
	"name"	varchar NOT NULL,
	"total_jobs"	integer NOT NULL,
	"pending_jobs"	integer NOT NULL,
	"failed_jobs"	integer NOT NULL,
	"failed_job_ids"	text NOT NULL,
	"options"	text,
	"cancelled_at"	integer,
	"created_at"	integer NOT NULL,
	"finished_at"	integer,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "jobs" (
	"id"	integer NOT NULL,
	"queue"	varchar NOT NULL,
	"payload"	text NOT NULL,
	"attempts"	integer NOT NULL,
	"reserved_at"	integer,
	"available_at"	integer NOT NULL,
	"created_at"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "migrations" (
	"id"	integer NOT NULL,
	"migration"	varchar NOT NULL,
	"batch"	integer NOT NULL,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "password_reset_tokens" (
	"email"	varchar NOT NULL,
	"token"	varchar NOT NULL,
	"created_at"	datetime,
	PRIMARY KEY("email")
);
CREATE TABLE IF NOT EXISTS "request_documents" (
	"id"	integer NOT NULL,
	"request_id"	integer NOT NULL,
	"file"	varchar NOT NULL,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("request_id") REFERENCES "clearance_requests"("id")
);
CREATE TABLE IF NOT EXISTS "sessions" (
	"id"	varchar NOT NULL,
	"user_id"	integer,
	"ip_address"	varchar,
	"user_agent"	text,
	"payload"	text NOT NULL,
	"last_activity"	integer NOT NULL,
	PRIMARY KEY("id")
);
CREATE TABLE IF NOT EXISTS "users" (
	"id"	integer NOT NULL,
	"name"	varchar NOT NULL,
	"email"	varchar NOT NULL,
	"phone_no"	varchar NOT NULL,
	"level"	varchar,
	"form_no"	varchar,
	"jamb_no"	varchar,
	"department"	varchar NOT NULL,
	"profile_photo"	varchar,
	"email_verified_at"	datetime,
	"password"	varchar NOT NULL,
	"role"	varchar NOT NULL,
	"remember_token"	varchar,
	"created_at"	datetime,
	"updated_at"	datetime,
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "cache" VALUES ('da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1723498500;',1723498500);
INSERT INTO "cache" VALUES ('da4b9237bacccdf19c0760cab7aec4a8359010b0','i:1;',1723498500);
INSERT INTO "cache" VALUES ('admission_officer@gmail.com|127.0.0.1:timer','i:1723534304;',1723534304);
INSERT INTO "cache" VALUES ('admission_officer@gmail.com|127.0.0.1','i:1;',1723534304);
INSERT INTO "clearance_requests" VALUES (6,2,'processing','2024-08-12 21:34:02','2024-08-12 21:34:02');
INSERT INTO "desks" VALUES (1,1,6,'admin',1,1,'2024-08-12 21:34:02','2024-08-13 09:39:12');
INSERT INTO "desks" VALUES (2,3,6,'court',2,1,'2024-08-13 09:39:12','2024-08-13 10:22:33');
INSERT INTO "desks" VALUES (3,4,6,'student_affairs',3,1,'2024-08-13 10:22:33','2024-08-13 10:24:58');
INSERT INTO "desks" VALUES (4,5,6,'department',4,0,'2024-08-13 10:24:58','2024-08-13 10:30:27');
INSERT INTO "migrations" VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO "migrations" VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO "migrations" VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO "migrations" VALUES (4,'2024_08_11_204218_create_clearance_requests_table',1);
INSERT INTO "migrations" VALUES (5,'2024_08_11_204449_create_desks_table',1);
INSERT INTO "migrations" VALUES (6,'2024_08_11_230109_create_request_documents_table',1);
INSERT INTO "request_documents" VALUES (10,6,'clearance_9P7JPbnZs7g9OW12.pdf','2024-08-12 21:34:02','2024-08-12 21:34:02');
INSERT INTO "request_documents" VALUES (11,6,'clearance_YkWNqSZ0FzGnQDt2.jpg','2024-08-12 21:34:02','2024-08-12 21:34:02');
INSERT INTO "request_documents" VALUES (12,6,'clearance_1OCHydIvYEWMKVf2.jpg','2024-08-12 21:34:02','2024-08-12 21:34:02');
INSERT INTO "sessions" VALUES ('vZzlHYnCX39qw2r1tqyHnI8jH2341AOq4XbtZdr4',2,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidEVBNlgyMFYzWmFrNlU4ekJaVHEzSG5xcWR5Y2lnOTQ1dWNJQVlCUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=',1723545346);
INSERT INTO "sessions" VALUES ('ImP6TY2dAsIRuQes0fNrCgHxcFe0xEBSrW38HnoN',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 OPR/112.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2VJc2Zxb3pOSWwxbU9OYkJNNm5UMWd2Sm5JS1hzdmJITklGWkJqeiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC92aWV3LWRlc2svNCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==',1723545338);
INSERT INTO "users" VALUES (1,'Greene Staff','admission_office@gmail.com','0812457890','staff','','','Admission Office',NULL,NULL,'$2y$12$5pwAfA1JcN5MhWqF4ziPoeXhp9dW4ja58QmTTo/6TjVIuc41DVn1C','admission_office',NULL,'2024-08-12 18:37:58','2024-08-12 18:37:58');
INSERT INTO "users" VALUES (2,'Gtechno Project','ucodetut@gmail.com','08124567893','HND1','1234568963','','Computer Science',NULL,NULL,'$2y$12$9k4Z19GrBr6oMQBIRq.boOl7e2vqTe4Wy5vbwvpHIFtamUE1nYU/u','student',NULL,'2024-08-12 19:36:52','2024-08-12 19:36:52');
INSERT INTO "users" VALUES (3,'High Court','court@gmail.com','08123654896','staff','','','Court',NULL,NULL,'$2y$12$AdCeLHyxB6ZwTR2bSEtxL./ImqSG94NLxbBN6D/.MwxUdoKaZDEgC','court',NULL,'2024-08-13 08:46:35','2024-08-13 08:46:35');
INSERT INTO "users" VALUES (4,'Student Affairs','student_affairs@gmail.com','08124536970','staff','','','Student Affairs',NULL,NULL,'$2y$12$PhQwaYKjHnsfWMr88Tk.Mea4avMFzJhzg1eg5Hw061woU4C0TqTJ2','student_affairs',NULL,'2024-08-13 08:47:56','2024-08-13 08:47:56');
INSERT INTO "users" VALUES (5,'Course Department','department@gmail.com','08102345783','staff','','','Computer Science',NULL,NULL,'$2y$12$ClAl2UJhz427OJelcHejDeDzpBBWGXrEXAJ0DwTM0m3ylQwLL4zmy','department',NULL,'2024-08-13 08:49:21','2024-08-13 08:49:21');
INSERT INTO "users" VALUES (6,'Final Admin','final_admin@gmail.com','08123456931','staff','','','Admin',NULL,NULL,'$2y$12$8TqSmsxMTEE7nS.gtNeU8elfYR2o30Goeif7LWrfohoBI14jeEIPK','final_admin',NULL,'2024-08-13 08:53:55','2024-08-13 08:53:55');
CREATE UNIQUE INDEX IF NOT EXISTS "failed_jobs_uuid_unique" ON "failed_jobs" (
	"uuid"
);
CREATE INDEX IF NOT EXISTS "jobs_queue_index" ON "jobs" (
	"queue"
);
CREATE INDEX IF NOT EXISTS "sessions_last_activity_index" ON "sessions" (
	"last_activity"
);
CREATE INDEX IF NOT EXISTS "sessions_user_id_index" ON "sessions" (
	"user_id"
);
CREATE UNIQUE INDEX IF NOT EXISTS "users_email_unique" ON "users" (
	"email"
);
CREATE UNIQUE INDEX IF NOT EXISTS "users_phone_no_unique" ON "users" (
	"phone_no"
);
COMMIT;
