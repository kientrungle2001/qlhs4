PzkSlideshow = PzkObj.pzkExt({
	activeClass: 'pzk_slideactive',
	hoverable: false,
	init: function() {
		if (this.type == 'nivo') {
			this.$().nivoSlider({
				startSlide: 0,
				animSpeed: parseInt(this.animSpeed),
				pauseTime: parseInt(this.pauseTime),
				directionNav: true,
				controlNav: true
			});
		} else {
			var self = this;
			self.slides = self.$().children();
			self.curIndex = 0;
			self.duration = parseInt(self.duration);
			self.slides.eq(self.curIndex).addClass(self.activeClass);
			setInterval(function() {
				self.slides.eq(self.curIndex).removeClass(self.activeClass);
				self.curIndex = (self.curIndex + 1) % self.slides.length;
				self.slides.eq(self.curIndex).addClass(self.activeClass);
			}, self.duration);
		}
	}
});