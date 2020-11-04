from django.db import models
from django.utils import timezone

class Potoks (models.Model):

    name = models.CharField("Название", max_length=100)
    order_date = models.DateField(verbose_name='Дата потока', default=timezone.now)



    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "Поток"
        verbose_name_plural = "Потоки"


class Courses (models.Model):

    name = models.CharField("Название", max_length=100)
    description = models.TextField("Описание", max_length= 1000)
    price = models.CharField("Цена", max_length=100)
    hour = models.CharField("Кол-во часов", max_length=100, blank=True)
    category = models.ForeignKey(Potoks, verbose_name='Категория', default=None, on_delete=models.CASCADE)
    url = models.URLField("Ссылка", max_length=1000, blank=True)


    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "Курс НАО"
        verbose_name_plural = "Курсы НАО"
# Create your models here.
