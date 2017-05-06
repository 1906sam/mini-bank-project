<script>
    var list = '1,2,3,4,8,9,10,20,21,22,23,24';
    list = list.split(',');
    var arrayList = [];
    var firstEle = 0, lastEle = 0;
    list[-1] = -2;

    for(var i=-1; i<list.length; i++)
    {
        if(i == 0)
            firstEle = list[0];

        if(((list[i+1] - list[i]) > 1) && i >= 0 && i <= (list.length - 1))
        {
            lastEle = list[i];
            arrayList.push('['+firstEle+','+lastEle+']');
            firstEle = list[i+1];
        }
        else if(i == (list.length - 1))
        {
            lastEle = list[i];
            arrayList.push('['+firstEle+','+lastEle+']');
        }
    }
    alert(arrayList);
</script>