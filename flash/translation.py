from  .models import *
from  modeltranslation.translator import register,TranslationOptions

@register(Flash)
class FlashTranslationOptions(TranslationOptions):
    fields = ('name', 'description','url')
