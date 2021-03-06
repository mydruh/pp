# Generated by Django 3.1.2 on 2020-10-17 11:17

from django.db import migrations, models


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Reviews',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Имя')),
                ('surname', models.CharField(max_length=100, verbose_name='Фамилия')),
                ('iin', models.CharField(max_length=100, verbose_name='ИИН')),
                ('email', models.EmailField(max_length=254)),
                ('phone', models.CharField(default='SOME STRING', max_length=15, verbose_name='Телефон')),
            ],
            options={
                'verbose_name': 'Обратная связь основа',
                'verbose_name_plural': 'Обратная связь основа',
            },
        ),
    ]
