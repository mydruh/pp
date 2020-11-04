from django.shortcuts import render
from django.views.generic.base import View


def home(request):



    return render(request, 'index.html')

def almaty(request):



    return render(request, 'almaty.html')


def loading(request):



    return render(request, 'preloader.html')

def test(request):



    return render(request, 'test.html')

def team(request):



    return render(request, 'team.html')