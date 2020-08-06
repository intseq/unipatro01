SELECT * FROM user_list

SELECT * FROM account_list


SELECT SUBSTR(acc_account,0,-2) FROM account_list



SELECT * FROM user_list

INSERT INTO user_list (usr_id,usr_used,usr_country,usr_language,usr_pwd,usr_name,usr_email,usr_grade,usr_agree,usr_regdate,usr_updated,usr_created,usr_approval) 
SELECT usr_id,'Y','kor','ko','D_4avRoIIVNTwjPW4AlhPpXuxCU4Mqdhryj_N6xaFQw-',usr_id,'aaa@aaa.com','A','Y','20190909',NOW(),NOW(),'Y' FROM account_list

UPDATE user_list
SET
usr_country = 'ko'
,usr_language='kr'






