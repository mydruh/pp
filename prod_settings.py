import os
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent



SECRET_KEY = ')7-$xy_b)+v=5_421$!3421x24m17=g!$8n!=p+aqh9_tw^ktesk7nutgde'

DEBUG = False

ALLOWED_HOSTS = ["127.0.0.1"]

DATABASES = {
    'default': {
        'ENGINE': 'django.db.backends.postgresql_psycopg2',
        'NAME': 'movie',
        'USER': 'john',
        'PASSWORD' : '123456',
        'HOST' : 'localhost',
        'PORT' : '5432',


    }
}

STATICFILES_DIRS = [
    os.path.join(BASE_DIR, 'static')
]
