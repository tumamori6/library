		@articles
		-id pk ai
		-topic_id int 11 uq nn
		-category_id int 11 nn
		-title text nn
		-img_src varchar 255 nn
		-created_at datetime nn
		-updated_at datetime
		-deleted_at datetime
				@article_to_tag
				-id pk ai
				-topic_id int 11 foreign topic_id nn
				-tag_id int 11 foreign tag_id nn
				@tags
				-id pk ai
				-name text nn
				@article_views
				-id pk ai
				-topic_id int 11 uq nn
				-n_user_id varchar 255 ※@remote_addr
				-total_view bigint 20 nn
		@contents
		-id pk ai
		-topic_id int 11 foreign topic_id
		-content_id int 11 not_nul
		-content_body text
		-anchor int 11
		-created_at datetime nn
		-updated_at datetime
		-deleted_at datetime
		@comments
		-id pk ai
		-n_user_id varchar 255 ※@remote_addr
		-topic_id int 11 foreign topic_id nn
		-comment_id int 11 not_nul
		-comment_body text
		-anchor int 11
		-created_at datetime nn
		-updated_at datetime
		-deleted_at datetime
