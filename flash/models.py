from django.db import models


# Create your models here.
class Flash (models.Model):

    name = models.CharField("Название", max_length=100)
    description = models.TextField("Описание", max_length= 1000, blank=True)
    price = models.CharField("Цена", max_length=100)


    url = models.URLField("Ссылка", max_length=1000, blank=True)


    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "Флешка"
        verbose_name_plural = "Флешки"
# Create your models here.
