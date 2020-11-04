# Generated by Django 3.1.2 on 2020-10-19 06:33

from django.db import migrations, models
import django.db.models.deletion
import django.utils.timezone


class Migration(migrations.Migration):

    initial = True

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Potoks',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Название')),
                ('order_date', models.DateField(default=django.utils.timezone.now, verbose_name='Дата потока')),
            ],
            options={
                'verbose_name': 'Поток',
                'verbose_name_plural': 'Потоки',
            },
        ),
        migrations.CreateModel(
            name='Courses_kaz',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Название')),
                ('description', models.CharField(max_length=150, verbose_name='Описание')),
                ('price', models.CharField(max_length=100, verbose_name='Цена')),
                ('category', models.ForeignKey(default=None, on_delete=django.db.models.deletion.CASCADE, to='courses.potoks', verbose_name='Категория')),
            ],
            options={
                'verbose_name': 'Курс kz',
                'verbose_name_plural': 'Курсы kz',
            },
        ),
        migrations.CreateModel(
            name='Courses',
            fields=[
                ('id', models.AutoField(auto_created=True, primary_key=True, serialize=False, verbose_name='ID')),
                ('name', models.CharField(max_length=100, verbose_name='Название')),
                ('description', models.CharField(max_length=150, verbose_name='Описание')),
                ('price', models.CharField(max_length=100, verbose_name='Цена')),
                ('category', models.ForeignKey(default=None, on_delete=django.db.models.deletion.CASCADE, to='courses.potoks', verbose_name='Категория')),
            ],
            options={
                'verbose_name': 'Курс',
                'verbose_name_plural': 'Курсы',
            },
        ),
    ]