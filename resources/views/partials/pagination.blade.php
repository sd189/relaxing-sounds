<ul class="pagination justify-content-center">
    @if($pagination['currentPage'] != 1 && $pagination['currentPage'] > 1)
        <li class="page-item"><a href="?page={{$pagination['currentPage']-1}}" class="page-link" aria-label="prev">Previous</a></li>
    @endif
    @if ($pagination['currentPage'] - 1 > 2)
            <li class="page-item"><a class="page-link" href="?page=1">1</a></li>
        <span>…</span>
    @endif
    @for ($i = 0; $i < $pagination['lastPage']; $i++)
        @if($pagination['currentPage'] == $i+1)
            <li class="page-item disabled">
                <a href="#" class="page-link disabled">{{$i+1}}</a>
            </li>
        @else
            @if ($i+1 > $pagination['currentPage'] && (($i+1) - $pagination['currentPage']) <= 2)
                    <li class="page-item"><a class="page-link" href="?page={{$i+1}}">{{$i+1}}</a></li>
            @elseif ($i+1 < $pagination['currentPage'] && ($pagination['currentPage'] - ($i+1)) <= 2)
                    <li class="page-item"><a class="page-link" href="?page={{$i+1}}">{{$i+1}}</a></li>
            @endif
        @endif
    @endfor
    @if ($pagination['lastPage'] - $pagination['currentPage'] > 2)
        <span>…</span>
            <li class="page-item"><a class="page-link" href="?page={{$pagination['lastPage']}}">{{$pagination['lastPage']}}</a></li>
    @endif

    @if($pagination['currentPage'] != $pagination['lastPage'])
            <li class="page-item"><a class="page-link" href="?page={{$pagination['currentPage']+1}}" class="next-page float-right" aria-label="next">Next</a></li>
    @endif
</ul>
