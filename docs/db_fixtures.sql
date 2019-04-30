INSERT INTO app.App_Project (id, name, description) VALUES (1, 'My Online Shop', 'My fance online shop which uses AaaS.');
INSERT INTO app.App_Project_Repository (id, project_id, name, description) VALUES (1, 1, 'Blog', 'Blog repository holds services for our blog.');
INSERT INTO app.App_Project_Repository (id, project_id, name, description) VALUES (2, 1, 'Catalog', 'Catalog repository holds services for our catalog.');
INSERT INTO app.App_Repository_Service (id, repository_id, name, description, type) VALUES (1, 1, 'Article', 'Articles for our blog repository.', 'list');
INSERT INTO app.App_Repository_Service (id, repository_id, name, description, type) VALUES (2, 1, 'Label', 'Labels for our blog repository.', 'list');
INSERT INTO app.App_Repository_Service (id, repository_id, name, description, type) VALUES (3, 1, 'Comment', 'Comments for our blog repository.', 'list');
INSERT INTO app.App_Repository_Service (id, repository_id, name, description, type) VALUES (4, 2, 'Product', 'Products service for our catalog repository.', 'list');
INSERT INTO app.App_Repository_Service (id, repository_id, name, description, type) VALUES (5, 2, 'Category', 'Categories for our catalog repository.', 'tree');
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (1, 1, 'title', 'Title for our blog post.', 'string', 255, 0, 0, null, null);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (2, 1, 'post', 'The actual blog post.', 'text', 8192, 0, 0, null, null);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (3, 2, 'value', 'The label value.', 'string', 255, 0, 0, null, null);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (4, 3, 'author', 'The author of the comment.', 'string', 255, 0, 0, null, null);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (5, 3, 'timestamp', 'The timestamp of the comment.', 'datetime', 8, 0, 0, null, null);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (6, 4, 'name', 'The actual product name.', 'string', 255, 0, 0, null, null);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (7, 4, 'description', 'The product description.', 'text', 4096, 0, 0, null, null);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (8, 4, 'prize', 'The product prize.', 'float', 10, 0, 1, 2, 3);
INSERT INTO app.App_Service_Field (id, service_id, name, description, data_type, length, is_unique, is_nullable, data_type_precision, data_type_scale) VALUES (9, 5, 'name', 'The category name.', 'string', 255, 1, 0, null, null);