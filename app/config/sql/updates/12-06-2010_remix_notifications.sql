ALTER TABLE `remix_notifications` CHANGE `ntype` `ntype` ENUM( 'positive', 'neutral', 'generosity', 'conformity', 'reputation', 'fairness', 'nonotification' ) NOT NULL DEFAULT 'neutral';

INSERT INTO `notification_types` ( `id` , `type` , `template` , `is_admin` , `negative` )
VALUES (
NULL , 'project_remixed_fairness','Your project <a href="/projects/{to_user_name}/{project_id}">{project_name}</a> was remixed. Scratch is about sharing and it is great that you are giving back by letting others use your projects!ﾊ<a href="/projects/{from_user_name}/%s">Check out the remix</a>.','0', '0'
);

UPDATE `notification_types` SET `template` = 'Congratulations! Your projectﾊ<a href="/projects/{to_user_name}/{project_id}">{project_name}</a>ﾊwas remixed.ﾊ<a href="/projects/{from_user_name}/%s">Check out the remix</a>.' WHERE `type` ='project_remixed_positive';

UPDATE `notification_types` SET `template` = 'Your projectﾊ<a href="/projects/{to_user_name}/{project_id}">{project_name}</a>ﾊwas remixed.ﾊ<a href="/projects/{from_user_name}/%s">Check out the remix</a>.' WHERE `type`= 'project_remixed_neutral';


UPDATE `notification_types` SET `template` ='Your projectﾊ<a href="/projects/{to_user_name}/{project_id}">{project_name}</a>ﾊwas remixed. Sharing your work is a generous thing to do and a good thing for the Scratch community!ﾊ<a href="/projects/{from_user_name}/%s">Check out the remix</a>.' WHERE `type` = 'project_remixed_generosity';

UPDATE `notification_types` SET `template` ='Your projectﾊ<a href="/projects/{to_user_name}/{project_id}">{project_name}</a>ﾊwas remixed. A lot of people enjoy having their projects remixed!ﾊ<a href="/projects/{from_user_name}/%s">Check out the remix</a>.' WHERE`type` = 'project_remixed_conformity';

UPDATE `notification_types` SET `template` ='Your projectﾊ<a href="/projects/{to_user_name}/{project_id}">{project_name}</a>ﾊwas remixed. People respect your work and get inspired by it!ﾊ<a href="/projects/{from_user_name}/%s">Check out the remix</a>.' WHERE`type` = 'project_remixed_reputation';


