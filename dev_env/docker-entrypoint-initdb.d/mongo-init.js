print('***** MONGO INIT STARTS *****');

db = db.getSiblingDB('admin');
db.auth("root", "password");
db = db.getSiblingDB('starter');

db.createUser({
    'user': "admin",
    'pwd': "tiger",
    'roles': [
        {
            'role': 'readWrite',
            'db': 'starter'
        }
    ]
});

db.createCollection('collection_test');

print('***** MONGO INIT ENDS *****');
