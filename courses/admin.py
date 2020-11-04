from django.contrib import admin
from django import forms

from  modeltranslation.admin import TranslationAdmin
from .models import *
admin.site.register(Courses)

admin.site.register(Potoks)
admin.site.register(Reviews)

# Register your models here.



