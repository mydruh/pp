from django.shortcuts import render
from django.shortcuts import render , redirect
from django.views.generic.base import View
from .models import Flash


# Create your views here.
class FlashView(View):
    def get(self,request):
        flash = Flash.objects.all()
        return render(request, "flash.html", {"flash_list": flash})


