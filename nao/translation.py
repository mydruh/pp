from  .models import *
from  modeltranslation.translator import register,TranslationOptions

@register(Courses)
class CoursesTranslationOptions(TranslationOptions):
    fields = ('name', 'description','url')
