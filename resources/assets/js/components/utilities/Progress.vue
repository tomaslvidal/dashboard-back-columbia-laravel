<template>
    <svg
    :height="radius * 2"
    :width="radius * 2"
    >
        <circle
        stroke="#25beaf"
        :stroke-dasharray="circumference + ' ' + circumference"
        :style="{ strokeDashoffset: strokeDashoffset }"
        :stroke-width="stroke"
        fill="transparent"
        :r="normalizedRadius"
        :cx="radius"
        :cy="radius"
        />

        <text style="stroke-width: 0px; font-size: 10px; font-weight: 600;" x="50%" y="50%" text-anchor="middle" stroke="#51c5cf" stroke-width="1px" dy=".3em">
            {{this.progress_item}}
        </text>
    </svg>
</template>

<script>
export default{
  props: {
    radius: Number,
    progress_item: Number,
    stroke: Number
  },
  data() {
    const normalizedRadius = this.radius - this.stroke * 2;

    const circumference = normalizedRadius * 2 * Math.PI;
    
    return {
      normalizedRadius,
      circumference
    };
  },
  computed: {
    strokeDashoffset() {
      return this.circumference - this.progress_item / 100 * this.circumference;
    }
  }
}
</script>

<style scoped>
    circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>