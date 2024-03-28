// WelcomeAnimation.js
export default {
  data() {
    return {
      canvas: null,
      ctx: null,
      animationFrame: null,
    };
  },
  mounted() {
    this.initializeCanvas();
    this.animate();
  },
  methods: {
    initializeCanvas() {
      this.canvas = this.$refs.canvas;
      this.ctx = this.canvas.getContext("2d");
      this.canvas.width = window.innerWidth;
      this.canvas.height = window.innerHeight;
    },
    animate() {
      // Créez un ciel étoilé en noir
      this.ctx.fillStyle = "black";
      this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);

      // Dessinez des étoiles scintillantes
      for (let i = 0; i < 100; i++) {
        const x = Math.random() * this.canvas.width;
        const y = Math.random() * this.canvas.height;
        const radius = Math.random() * 2;
        const opacity = Math.random();

        this.ctx.beginPath();
        this.ctx.arc(x, y, radius, 0, Math.PI * 2);
        this.ctx.fillStyle = `rgba(255, 255, 255, ${opacity})`;
        this.ctx.fill();
      }

      this.animationFrame = requestAnimationFrame(this.animate);
    },
  },
  beforeDestroy() {
    cancelAnimationFrame(this.animationFrame);
  },
};
