from django.db import models
from django.utils import timezone
"""
class Content(models.Model):
    name = models.CharField("Имя" , max_length=100)
    surname = models.CharField("Фамилия" , max_length=100)
    iin = models.CharField("ИИН" , max_length=100)
    email = models.EmailField()
    phone = models.CharField("Телефон" , max_length=15, default='SOME STRING')
    course = models.CharField("Курс", max_length=150, blank=True)
    STATUS_BUY = 'buy'

    STATUS_HOLD = 'hold'

    STATUS_CHOICES = (
        (STATUS_BUY, 'Оплатил'),

        (STATUS_HOLD, 'Не оплатил')
    )

    status = models.CharField(
        max_length=100,
        verbose_name='Статус покупки',
        choices=STATUS_CHOICES,
        default=STATUS_HOLD
    )

    def __str__(self):
        return self.name

    class Meta:
        verbose_name = "Обратная связь основа"
        verbose_name_plural = "Обратная связь основа"
# Create your models here.
"""
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
        verbose_name = "Курс"
        verbose_name_plural = "Курсы"