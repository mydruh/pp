from django.shortcuts import render
from django.shortcuts import render , redirect
from django.views.generic.base import View
from .models import Courses


# Create your views here.
class NaoView(View):
    def get(self,request):
        nao = Courses.objects.all()
        return render(request, "nao.html", {"nao_list": nao})


