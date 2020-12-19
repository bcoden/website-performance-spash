<svg viewBox="0 0 36 36" class="circular-chart {{ $color }}">
    <path class="circle-bg"
          d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
    />
    <path class="circle"
          stroke-dasharray="{{ $score }}, 100"
          d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"
    />
    <text x="18" y="20.35" class="percentage">{{ $score }}</text>
</svg>
